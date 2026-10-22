<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\ConfigureFilterAutocompleteUsersTrait;
use App\Admin\Traits\ConfigureFormAutocompleteUsersTrait;
use App\Contract\Dictionary\User\UserRole;
use App\Entity\Site\Site;
use App\Repository\Site\SiteRepository;
use Carbon\CarbonImmutable;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * @method Site|null getSubject()
 */
class SiteAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;
    use ConfigureFilterAutocompleteUsersTrait;
    use ConfigureFormAutocompleteUsersTrait;

    protected SiteRepository $siteRepository;

    #[Required]
    public function initDependencies(
        SiteRepository $siteRepository,
    ): void {
        $this->siteRepository = $siteRepository;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'domain',
        ];
    }

    protected function getAccessMapping(): array
    {
        return [
            'token-reset' => 'TOKEN_RESET',
            'settings'    => 'SETTINGS',
            'cache-clear' => 'CACHE_CLEAR',
        ];
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection->add('token-reset', $this->getRouterIdParameter() . '/token-reset');
        $collection->add('settings', $this->getRouterIdParameter() . '/settings');
        $collection->add('cache-clear', $this->getRouterIdParameter() . '/cache-clear');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'domain', 'SITE_ENTITY.LABEL.DOMAIN');
        $this->configureFilterFieldText($filter, 'title', 'SITE_ENTITY.LABEL.TITLE');

        $this->configureFilterFieldAutocompleteUsers($filter);
        $this->configureFilterFieldActive($filter);

        $this->configureFilterFieldText($filter, 'registrarEmail', 'SITE_ENTITY.LABEL.REGISTRAR_EMAIL');
        $this->configureFilterFieldText($filter, 'registrarName', 'SITE_ENTITY.LABEL.REGISTRAR_NAME');
        $this->configureFilterFieldDateRange($filter, 'registeredAt', 'SITE_ENTITY.LABEL.REGISTERED_AT');
        $this->configureFilterFieldDateRange($filter, 'expireAt', 'SITE_ENTITY.LABEL.EXPIRE_AT');

        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldActive($list);

        $this->configureListFieldText(
            $list,
            'domain_virtual',
            'SITE_ENTITY.LABEL.DOMAIN',
            [
                'virtual_field' => true,
                'sortable'      => false,
                'template'      => 'admin/CRUD/site/list__domain.html.twig',
                'header_style'  => 'width:300px;',
            ]
        );

        $this->configureListFieldManyToMany(
            $list,
            'users',
            'email',
            'SITE_ENTITY.LABEL.USERS',
            [
                'admin_code' => 'admin.user.all',
                'route'      => ['name' => 'show'],
            ]
        );

        $this->configureListFieldText(
            $list,
            'domain_details_virtual',
            'SITE_ENTITY.LABEL.DOMAIN_DETAILS',
            [
                'virtual_field' => true,
                'sortable'      => false,
                'template'      => 'admin/CRUD/site/list__domain_details.html.twig',
            ]
        );

        $this->configureListFieldText(
            $list,
            'settings_virtual',
            'SITE_ENTITY.LABEL.SETTINGS',
            [
                'virtual_field' => true,
                'sortable'      => false,
                'template'      => 'admin/CRUD/site/list__settings.html.twig',
                'header_style'  => 'width:235px;',
            ]
        );

        $this->configureListFieldChildrenActions(
            list: $list,
            width: '170px',
            template: 'admin/CRUD/site/list__action_children.html.twig',
        );
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('SITE_ENTITY.SECTION.MAIN', ['class' => 'col-md-9']);

        $form->add(
            'domain',
            UrlType::class,
            [
                'required'    => false,
                'label'       => 'SITE_ENTITY.LABEL.DOMAIN',
                'help'        => 'SITE_ENTITY.HELP.DOMAIN',
                'constraints' => [
                    new NotBlank(),
                    new Url(),
                    new Callback([$this, 'validateFormFieldSiteDomain']),
                ],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'title',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'SITE_ENTITY.LABEL.TITLE',
                'help'               => 'SITE_ENTITY.HELP.TITLE',
                'constraints'        => [], // [new NotBlank()],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $this->configureFormFieldAutocompleteUsers($form);

        $form->end();

        $this->configureFormSectionSiteDomainRegistration($form);
    }

    private function configureFormSectionSiteDomainRegistration(FormMapper $form): void
    {
        $form->with('SITE_ENTITY.SECTION.DOMAIN_REGISTRATION', ['class' => 'col-md-3']);

        $form->add(
            'registrarEmail',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'SITE_ENTITY.LABEL.REGISTRAR_EMAIL',
                'help'               => 'SITE_ENTITY.HELP.REGISTRAR_EMAIL',
                'constraints'        => [new Email()],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'registrarName',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'SITE_ENTITY.LABEL.REGISTRAR_NAME',
                'help'               => 'SITE_ENTITY.HELP.REGISTRAR_NAME',
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $this->configureFormFieldDate(
            $form,
            'registeredAt',
            'SITE_ENTITY.LABEL.REGISTERED_AT',
            'SITE_ENTITY.HELP.REGISTERED_AT',
            false,
            [
                'mapped' => false,
                'data'   => $this->getSubject()?->getRegisteredAt(),
            ]
        );

        $this->configureFormFieldDate(
            $form,
            'expireAt',
            'SITE_ENTITY.LABEL.EXPIRE_AT',
            'SITE_ENTITY.HELP.EXPIRE_AT',
            false,
            [
                'mapped' => false,
                'data'   => $this->getSubject()?->getExpireAt(),
            ]
        );

        $form->end();
    }

    public function validateFormFieldSiteDomain($value, ExecutionContextInterface $context): void
    {
        if ($value === null) {
            return;
        }

        $entity = $this->siteRepository->findOneBy(['domain' => $value]);

        if ($entity !== null
            && $this->getSubject() !== null
            && $entity->getId() !== $this->getSubject()->getId()
        ) {
            $context
                ->buildViolation('SITE_ENTITY.ERROR.DOMAIN_TAKEN')
                ->setParameter('%DOMAIN%', $value)
                ->setTranslationDomain($this->getTranslationDomain())
                ->atPath('domain')->addViolation();
        }
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        /** @var ProxyQueryInterface|QueryBuilder $query */
        parent::configureQuery($query);

        $user = $this->getUser();

        if ($user && $user->hasRole(UserRole::SiteManager->value)) {
            // allow access only for available sites
            $alias = current($query->getRootAliases());
            $query->join("$alias.users", 'siteManager')
                ->andWhere('siteManager = :siteManager')
                ->setParameter('siteManager', $user);
        }

        return $query;
    }

    protected function prePersist(object $object): void
    {
        /** @var Site $object */
        parent::prePersist($object);
        $this->prepareCarbonImmutables($object);
    }

    protected function preUpdate(object $object): void
    {
        /** @var Site $object */
        parent::preUpdate($object);
        $this->prepareCarbonImmutables($object);
    }

    private function prepareCarbonImmutables(Site $site): void
    {
        if ($this->hasSubject()
            && ($form = $this->getForm())
        ) {
            if ($form->has('registeredAt')) {
                $registeredAt = $form->get('registeredAt')->getData()
                    ? CarbonImmutable::instance($form->get('registeredAt')->getData())->startOfDay()
                    : null;
                $site->setRegisteredAt($registeredAt);
            }

            if ($form->has('expireAt')) {
                $expireAt = $form->get('expireAt')->getData()
                    ? CarbonImmutable::instance($form->get('expireAt')->getData())->endOfDay()
                    : null;
                $site->setExpireAt($expireAt);
            }
        }
    }
}
