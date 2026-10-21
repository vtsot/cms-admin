<?php

declare(strict_types=1);

namespace App\Admin\User;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\ConfigureFilterAutocompleteSitesTrait;
use App\Admin\Traits\ConfigureFormAutocompleteSitesTrait;
use App\Contract\Dictionary\User\UserRole;
use App\Contract\Entity\UserInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Filter\Model\FilterData;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\String\UnicodeString;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Service\Attribute\Required;

use function current;
use function implode;
use function in_array;
use function strtoupper;
use function Symfony\Component\String\u;

/**
 * @method UserInterface|null getSubject()
 */
abstract class AbstractUserAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;
    use ConfigureFilterAutocompleteSitesTrait;
    use ConfigureFormAutocompleteSitesTrait;

    public const USE_GOOGLE_AUTHENTICATOR = false;
    public const MULTIPLE_ROLES           = false;

    /**
     * @return string[]
     */
    abstract protected function resolveUserRoles(): array;

    protected UserRepository $userRepository;

    #[Required]
    public function initDependencies(
        UserRepository $userRepository,
    ): void {
        $this->userRepository = $userRepository;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'DESC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        /** @var ProxyQueryInterface|QueryBuilder $query */
        parent::configureQuery($query);

        // disable softdeleteable
        if ($query->getEntityManager()->getFilters()->isEnabled('softdeleteable')) {
            $query->getEntityManager()->getFilters()->disable('softdeleteable');
        }

        $alias      = current($query->getRootAliases());
        $conditions = ["{$alias}.roles = 'ROLES_ARE_NOT_SET'"];

        if ($roles = $this->resolveUserRoles()) {
            $conditions = [];

            foreach ($roles as $key => $role) {
                $conditions[] = "{$alias}.roles LIKE :role_{$key}";
                $query->setParameter(":role_{$key}", '%' . $role . '%');
            }
        }
        $query->andWhere($query->expr()->orX(...$conditions));

        return $query;
    }

    protected function getRolesChoices(): array
    {
        // return [];
        $choices = [];
        $roles   = $this->resolveUserRoles();

        foreach ($roles as $role) {
            $choices[$this->trans('USER_ENTITY.ROLE.' . strtoupper($role))] = $role;
        }

        return $choices;
    }

    protected function isRegularUserRole(): bool
    {
        return in_array(UserRole::User->value, $this->resolveUserRoles(), true);
    }

    protected function configureFilterFieldRoles(
        DatagridMapper $filter,
        ?string $name = null,
        array $choices = [],
        ?string $label = null,
        array $options = [],
    ): void {
        $name ??= 'roles';
        $choices = $choices ?: $this->getRolesChoices();
        $label ??= 'USER_ENTITY.LABEL.ROLES';

        $filter->add(
            $name,
            CallbackFilter::class,
            [
                'label'         => $label,
                'field_type'    => ChoiceType::class,
                'field_options' => [
                    'choices'            => $choices,
                    'translation_domain' => $this->getTranslationDomain(),
                ],
                'callback' => static function (
                    ProxyQuery|QueryBuilder $qb,
                    string $alias,
                    string $field,
                    FilterData $data,
                ) {
                    if ($data->hasValue() && $role = $data->getValue()) {
                        $qb->andWhere(sprintf('%s.%s LIKE :role ', $alias, $field))
                            ->setParameter('role', '%' . (new UnicodeString($role))->toString() . '%');

                        return true;
                    }

                    return false;
                },
            ]
        );
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'email', 'USER_ENTITY.LABEL.EMAIL');
        $this->configureFilterFieldText($filter, 'firstName', 'USER_ENTITY.LABEL.FIRST_NAME');
        $this->configureFilterFieldText($filter, 'lastName', 'USER_ENTITY.LABEL.LAST_NAME');
        $this->configureFilterFieldRoles($filter);
        $this->configureFilterFieldAutocompleteSites($filter);

        if (static::USE_GOOGLE_AUTHENTICATOR) {
            $this->configureFilterFieldActive(
                $filter,
                'googleAuthenticatorEnabled',
                'USER_ENTITY.LABEL.GOOGLE_AUTHENTICATOR_ENABLED'
            );
        }

        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $optionsEdit = ['identifier' => true, 'route' => ['name' => 'edit']];
        $this->configureListFieldText($list, 'email', 'USER_ENTITY.LABEL.EMAIL', $optionsEdit);
        $this->configureListFieldText($list, 'firstName', 'USER_ENTITY.LABEL.FIRST_NAME');
        $this->configureListFieldText($list, 'lastName', 'USER_ENTITY.LABEL.LAST_NAME');

        $this->configureListFieldRoles($list);

        $this->configureListFieldManyToMany(
            $list,
            'sites',
            'domain',
            'USER_ENTITY.LABEL.SITES',
            [
                'route'      => ['name' => 'show'],
                'admin_code' => 'admin.site',
            ],
        );

        if (static::USE_GOOGLE_AUTHENTICATOR) {
            $this->configureListFieldActive(
                $list,
                'googleAuthenticatorEnabled',
                'USER_ENTITY.LABEL.GOOGLE_AUTHENTICATOR_ENABLED_LIST_LABEL'
            );
        }

        $this->configureListFieldActive($list);
        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureListFieldRoles(ListMapper $list): void
    {
        if (!$this->getRolesChoices()) {
            return;
        }

        $accessor = static function (User $subject) {
            $list = [];

            foreach ($subject->getRoles() as $role) {
                $list[] = u(UserRole::from($role)->name)->snake()->replace('_', ' ')->title(true);
            }

            return implode(', ', $list);
        };

        $this->configureListFieldText(
            $list,
            'roles',
            'USER_ENTITY.LABEL.ROLES',
            [
                'accessor' => $accessor,
                'sortable' => false,
            ]
        );
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('USER_ENTITY.SECTION.MAIN');

        $form->add(
            'email',
            TextType::class,
            [
                'required'    => true,
                'label'       => 'USER_ENTITY.LABEL.EMAIL',
                'help'        => 'USER_ENTITY.HELP.EMAIL',
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new Callback([$this, 'validateFormFieldUserEmail']),
                ],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $this->configureFormFieldText(
            $form,
            'firstName',
            'USER_ENTITY.LABEL.FIRST_NAME',
            'USER_ENTITY.HELP.FIRST_NAME'
        );

        $this->configureFormFieldText($form, 'lastName', 'USER_ENTITY.LABEL.LAST_NAME', 'USER_ENTITY.HELP.LAST_NAME');

        $user = $this->getSubject();

        $isPasswordRequired = $user && !$user->getId();

        $form
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type'          => PasswordType::class,
                    'required'      => $isPasswordRequired,
                    'first_options' => [
                        'label' => 'USER_ENTITY.LABEL.PASSWORD',
                        'attr'  => ['autocomplete' => 'new-password'],
                    ],
                    'second_options' => [
                        'label' => 'USER_ENTITY.LABEL.PASSWORD_REPEAT',
                        'attr'  => ['autocomplete' => 'new-password'],
                    ],
                    'invalid_message'    => $this->trans('USER_ENTITY.ERROR.PASSWORD_MISMATCH'),
                    'translation_domain' => $this->getTranslationDomain(),
                ]
            );

        if (static::USE_GOOGLE_AUTHENTICATOR) {
            $this->configureFormFieldsGoogleAuthenticator($form);
        }

        if ($rolesChoices = $this->getRolesChoices()) {
            if (static::MULTIPLE_ROLES) {
                $form
                    ->add(
                        'roles',
                        ChoiceType::class,
                        [
                            'required'           => true,
                            'multiple'           => static::MULTIPLE_ROLES,
                            'mapped'             => static::MULTIPLE_ROLES,
                            'label'              => 'USER_ENTITY.LABEL.ROLES',
                            'help'               => 'USER_ENTITY.HELP.ROLES',
                            'choices'            => $rolesChoices,
                            'constraints'        => [new NotBlank()],
                            'translation_domain' => $this->getTranslationDomain(),
                        ]
                    );
            } else {
                $form
                    ->add(
                        'roles',
                        ChoiceFieldMaskType::class,
                        [
                            'required' => false,
                            'multiple' => static::MULTIPLE_ROLES,
                            'mapped'   => static::MULTIPLE_ROLES,
                            'label'    => 'USER_ENTITY.LABEL.ROLES',
                            'help'     => 'USER_ENTITY.HELP.ROLES',
                            'choices'  => $rolesChoices,
                            'map'      => [
                                UserRole::SiteManager->value => ['sites'],
                            ],
                            'placeholder'        => 'CHOICE.NONE',
                            'data'               => $this->getSubject()?->getRoles()[0] ?? null,
                            'translation_domain' => $this->getTranslationDomain(),
                        ]
                    );
            }
        }

        $this->configureFormFieldAutocompleteSites($form);

        $form->end();
    }

    public function validateFormFieldUserEmail(?string $value, ExecutionContextInterface $context): void
    {
        if ($value === null) {
            return;
        }

        $entity = $this->userRepository->findOneByIdentifier($value);

        if ($entity !== null
            && $this->getSubject() !== null
            && $entity->getId() !== $this->getSubject()->getId()
        ) {
            $context
                ->buildViolation('USER_ENTITY.ERROR.EMAIL_TAKEN')
                ->setParameter('%EMAIL%', $value)
                ->setTranslationDomain($this->getTranslationDomain())
                ->atPath('email')->addViolation();
        }
    }

    protected function configureFormFieldsGoogleAuthenticator(FormMapper $form): void
    {
        $form
            ->add(
                'googleAuthenticatorEnabled',
                ChoiceFieldMaskType::class,
                [
                    'label'   => 'USER_ENTITY.LABEL.GOOGLE_AUTHENTICATOR_ENABLED',
                    'help'    => 'USER_ENTITY.HELP.GOOGLE_AUTHENTICATOR_ENABLED',
                    'choices' => self::$choicesYesNo,
                    'map'     => [
                        1 => ['googleAuthenticatorToken'],
                        0 => [],
                    ],
                    'required'           => true,
                    'translation_domain' => $this->getTranslationDomain(),
                ]
            )
            ->add(
                'googleAuthenticatorToken',
                TextType::class,
                [
                    'label' => 'USER_ENTITY.LABEL.GOOGLE_AUTHENTICATOR_TOKEN',
                    'help'  => $this->getSubject()?->getGoogleAuthenticatorToken()
                        ? 'USER_ENTITY.HELP.GOOGLE_AUTHENTICATOR_TOKEN_IS_SET'
                        : 'USER_ENTITY.HELP.GOOGLE_AUTHENTICATOR_TOKEN_NOT_SET',
                    'required' => false,
                ]
            );
    }

    protected function prePersist(object $object): void
    {
        /** @var User $object */
        $this->prepareUserRoles($object);
        $this->prepareUserSites($object);
    }

    protected function preUpdate(object $object): void
    {
        /** @var User $object */
        $this->prepareUserRoles($object);
        $this->prepareUserSites($object);
    }

    private function prepareUserRoles(User $user): void
    {
        if (!static::MULTIPLE_ROLES
            && $this->hasSubject()
            && $this->getRolesChoices()
            && ($form = $this->getForm())
            && $form->has('roles')
            && ($role = $form->get('roles')->getData())
            && in_array($role, $this->getRolesChoices(), true)
        ) {
            $user->setRoles([$role]);
        }
    }

    private function prepareUserSites(User $user): void
    {
        if ($user->hasRole(UserRole::Supervisor->value)) {
            $user->getSites()->clear();
        }
    }
}
