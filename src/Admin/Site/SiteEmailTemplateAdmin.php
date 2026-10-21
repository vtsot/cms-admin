<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\EmailTemplate;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;

use function count;
use function explode;
use function implode;
use function trim;

/**
 * @method EmailTemplate|null getSubject()
 */
class SiteEmailTemplateAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    public const CK_EDITOR_EMAIL_TEMPLATE_SITE_CONTACT    = 'email-template-site-contact';
    public const CK_EDITOR_EMAIL_TEMPLATE_SITE_EXPIRATION = 'email-template-site-expiration';

    private ValidatorInterface $validator;

    #[Required]
    public function initDependencies(
        ValidatorInterface $validator,
    ): void {
        $this->validator = $validator;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->clearExcept(['list', 'show', 'edit']);
        $collection->add('show_html', $this->getRouterIdParameter() . '/show-html');
        $collection->add('show_text', $this->getRouterIdParameter() . '/show-text');
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'code',
        ];
    }

    protected function getAccessMapping(): array
    {
        return [
            'show_html' => 'SHOW_HTML',
            'show_text' => 'SHOW_TEXT',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldText($filter, 'code', 'EMAIL_TEMPLATE_ENTITY.LABEL.CODE');
        $this->configureFilterFieldText($filter, 'subject', 'EMAIL_TEMPLATE_ENTITY.LABEL.SUBJECT');
        $this->configureFilterFieldActive($filter, 'sendToManagersActive', 'EMAIL_TEMPLATE_ENTITY.LABEL.SEND_TO_MANAGERS_ACTIVE');

        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldActive(
            list: $list,
            options: ['template' => 'admin/CRUD/email-template/list__active.html.twig']
        );

        $this->configureListFieldText(
            $list,
            'code',
            'EMAIL_TEMPLATE_ENTITY.LABEL.CODE',
            [
                'identifier'   => true, 'route' => ['name' => 'edit'],
                'header_style' => 'width:300px;',
            ]
        );

        $this->configureListFieldText($list, 'subject', 'EMAIL_TEMPLATE_ENTITY.LABEL.SUBJECT');
        $this->configureListFieldActive($list, 'sendToManagersActive', 'EMAIL_TEMPLATE_ENTITY.LABEL.SEND_TO_MANAGERS_ACTIVE');

        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list, ['show' => [], 'edit' => []]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('active', null, ['label' => 'FIELD.ACTIVE'])
            ->add('code', null, ['label' => 'EMAIL_TEMPLATE_ENTITY.LABEL.CODE']);

        $show
            ->add('sendTo', null, ['label' => 'EMAIL_TEMPLATE_ENTITY.LABEL.SEND_TO'])
            ->add('replyTo', null, ['label' => 'EMAIL_TEMPLATE_ENTITY.LABEL.REPLY_TO'])
            ->add('subject', null, ['label' => 'EMAIL_TEMPLATE_ENTITY.LABEL.SUBJECT']);

        if ($this->isEditableSendToManagersActiveFieldForTemplate()) {
            $show
                ->add(
                    'sendToManagersActive',
                    null,
                    ['label' => 'EMAIL_TEMPLATE_ENTITY.LABEL.SEND_TO_MANAGERS_ACTIVE']
                );
        }

        $show
            ->add(
                'placeholders',
                null,
                [
                    'virtual_field' => true,
                    'label'         => 'EMAIL_TEMPLATE_ENTITY.LABEL.PLACEHOLDERS',
                    'template'      => 'admin/CRUD/email-template/show__placeholders.html.twig',
                ]
            )
            ->add(
                'html',
                null,
                [
                    'label'    => 'EMAIL_TEMPLATE_ENTITY.LABEL.HTML',
                    'template' => 'admin/CRUD/email-template/show__html.html.twig',
                ]
            )
            ->add(
                'text',
                null,
                [
                    'label'    => 'EMAIL_TEMPLATE_ENTITY.LABEL.TEXT',
                    'template' => 'admin/CRUD/email-template/show__text.html.twig',
                ]
            )
            ->add('createdAt', 'datetime', ['label' => 'FIELD.CREATED_AT'])
            ->add('updatedAt', 'datetime', ['label' => 'FIELD.UPDATED_AT']);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with($this->trans('EMAIL_TEMPLATE_ENTITY.SECTION.MAIN'));

        $form
            ->add(
                'code',
                TextType::class,
                [
                    'label'    => 'EMAIL_TEMPLATE_ENTITY.LABEL.CODE',
                    'required' => false,
                    'attr'     => ['readonly' => true],
                    'disabled' => true,
                ]
            );

        $this->configureFormFieldActive(
            form: $form,
            name: 'active',
            help: 'EMAIL_TEMPLATE_ENTITY.HELP.ACTIVE',
            options: [
                'attr'     => !$this->isEditableActiveFieldForTemplate() ? ['readonly' => true] : [],
                'disabled' => !$this->isEditableActiveFieldForTemplate(),
            ]
        );

        if ($this->isEditableSendToManagersActiveFieldForTemplate()) {
            $this->configureFormFieldActive(
                form: $form,
                name: 'sendToManagersActive',
                label: 'EMAIL_TEMPLATE_ENTITY.LABEL.SEND_TO_MANAGERS_ACTIVE_FORM',
                help: 'EMAIL_TEMPLATE_ENTITY.HELP.SEND_TO_MANAGERS_ACTIVE',
            );
        }

        $this->configureFormFieldText(
            $form,
            'sendTo',
            'EMAIL_TEMPLATE_ENTITY.LABEL.SEND_TO',
            'EMAIL_TEMPLATE_ENTITY.HELP.SEND_TO',
            false,
            ['constraints' => [new Callback([$this, 'validateSendToEmails'])]]
        );

        $this->configureFormFieldText(
            $form,
            'replyTo',
            'EMAIL_TEMPLATE_ENTITY.LABEL.REPLY_TO',
            'EMAIL_TEMPLATE_ENTITY.HELP.REPLY_TO',
            false,
            ['constraints' => [new Email()]]
        );

        $this->configureFormFieldText(
            $form,
            'subject',
            'EMAIL_TEMPLATE_ENTITY.LABEL.SUBJECT',
            'EMAIL_TEMPLATE_ENTITY.HELP.SUBJECT',
            true,
            ['constraints' => [new NotBlank()]]
        );

        $form
            ->add(
                'placeholders',
                TextType::class,
                [
                    'mapped'   => false,
                    'label'    => $this->trans('EMAIL_TEMPLATE_ENTITY.LABEL.PLACEHOLDERS'),
                    'help'     => $this->trans('EMAIL_TEMPLATE_ENTITY.HELP.PLACEHOLDERS'),
                    'data'     => implode(', ', $this->resolvePlaceholders()),
                    'required' => false,
                    'attr'     => ['readonly' => true],
                ]
            );

        $form->add(
            'html',
            CKEditorType::class,
            [
                'required'    => false,
                'label'       => 'EMAIL_TEMPLATE_ENTITY.LABEL.HTML',
                'help'        => 'EMAIL_TEMPLATE_ENTITY.HELP.HTML',
                'config_name' => $this->resolveCKEditorConfigName(),
                'trim'        => true,
                'config'      => [],
            ],
        );

        $this->configureFormFieldTextarea(
            $form,
            'text',
            'EMAIL_TEMPLATE_ENTITY.LABEL.TEXT',
            'EMAIL_TEMPLATE_ENTITY.HELP.TEXT',
        );

        $form->end();
    }

    public function validateSendToEmails($value, ExecutionContextInterface $context): void
    {
        if (!$value) {
            return;
        }

        foreach (explode(',', $value) as $email) {
            $errors = $this->validator->validate(
                trim($email),
                new Email()
            );

            if (count($errors)) {
                $context
                    ->buildViolation('EMAIL_TEMPLATE_ENTITY.ERROR.INVALID_EMAIL')
                    ->atPath($context->getPropertyPath())
                    ->setParameter('%EMAIL%', $email)
                    ->setTranslationDomain($this->getTranslationDomain())
                    ->addViolation();
            }
        }
    }

    public function isEditableActiveFieldForTemplate(?EmailTemplate $subject = null): bool
    {
        $template = $subject ?? $this->getSubject();
        $code     = $template?->getCode();

        return match ($code) {
            EmailTemplate::CODE_CONTACT => true,
            default                     => false,
        };
    }

    private function isEditableSendToManagersActiveFieldForTemplate(): bool
    {
        return match ($this->getSubject()?->getCode()) {
            EmailTemplate::CODE_CONTACT,
            EmailTemplate::CODE_EXPIRATION_4_WEEKS_BEFORE,
            EmailTemplate::CODE_EXPIRATION_2_WEEKS_BEFORE,
            EmailTemplate::CODE_EXPIRATION_1_DAY_BEFORE => true,

            default => false,
        };
    }

    private function resolveCKEditorConfigName(): string
    {
        return match ($this->getSubject()?->getCode()) {
            EmailTemplate::CODE_CONTACT => self::CK_EDITOR_EMAIL_TEMPLATE_SITE_CONTACT,

            EmailTemplate::CODE_EXPIRATION_4_WEEKS_BEFORE,
            EmailTemplate::CODE_EXPIRATION_2_WEEKS_BEFORE,
            EmailTemplate::CODE_EXPIRATION_1_DAY_BEFORE => self::CK_EDITOR_EMAIL_TEMPLATE_SITE_EXPIRATION,

            default => self::CK_EDITOR_BASE_CONFIG,
        };
    }

    public function resolvePlaceholders(): array
    {
        return match ($this->getSubject()?->getCode()) {
            EmailTemplate::CODE_CONTACT => ['[[NAME]]', '[[EMAIL]]', '[[MESSAGE]]'],

            EmailTemplate::CODE_EXPIRATION_4_WEEKS_BEFORE,
            EmailTemplate::CODE_EXPIRATION_2_WEEKS_BEFORE,
            EmailTemplate::CODE_EXPIRATION_1_DAY_BEFORE => ['[[REGISTRAR_NAME]]', '[[REGISTRAR_EMAIL]]', '[[DOMAIN]]', '[[EXPIRE_AT]]'],

            default => [],
        };
    }
}
