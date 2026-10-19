<?php

declare(strict_types=1);

namespace App\Admin\Page;

//use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
//use App\Admin\Traits\ConfigurePermissionSectionFieldTrait;
//use App\Admin\Traits\EntityTranslationTrait;
//use App\CQ\Command\Page\ResetPagePermissionsCommand;
use App\Entity\Page\AbstractPage;
use App\Entity\Page\CommonPage;
use App\Entity\Page\SystemPage;
//use App\Repository\AbstractPageRepository;
//use App\Repository\SubscriptionPackageRepository;
//use App\Service\MessageBusHandler;
//use App\Service\TranslationCreator\EntityTranslationCreator\PageTranslationCreator;
//use FM\ElfinderBundle\Form\Type\ElFinderType;
//use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Repository\Page\AbstractPageRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * @method AbstractPage|null getSubject()
 */
class AbstractPageAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;
//    use ConfigurePermissionSectionFieldTrait;
//    use EntityTranslationTrait;

    protected AbstractPageRepository $pageRepository;

//    protected SubscriptionPackageRepository $subscriptionPackageRepository;

//    protected MessageBusHandler $messageBusHandler;

    private PageTranslationCreator $entityTranslationCreator;

    protected const SITEMAP_PRIORITY_CHOICES = [
        '0.1' => 0.1,
        '0.2' => 0.2,
        '0.3' => 0.3,
        '0.4' => 0.4,
        '0.5' => 0.5,
        '0.6' => 0.6,
        '0.7' => 0.7,
        '0.8' => 0.8,
        '0.9' => 0.9,
        '1.0' => 1.0,
    ];

    protected const SITEMAP_CHANGE_FREQUENCY_CHOICES = [
        'FREQUENCY.CHOICE.ALWAYS'  => 'always',
        'FREQUENCY.CHOICE.HOURLY'  => 'hourly',
        'FREQUENCY.CHOICE.DAILY'   => 'daily',
        'FREQUENCY.CHOICE.WEEKLY'  => 'weekly',
        'FREQUENCY.CHOICE.MONTHLY' => 'monthly',
        'FREQUENCY.CHOICE.YEARLY'  => 'yearly',
        'FREQUENCY.CHOICE.NEVER'   => 'never',
    ];

    #[Required]
    public function initDependencies(
        AbstractPageRepository $pageRepository,
//        SubscriptionPackageRepository $subscriptionPackageRepository,
//        MessageBusHandler $messageBusHandler,
//        PageTranslationCreator $entityTranslationCreator,
    ): void {
        $this->pageRepository                = $pageRepository;
//        $this->subscriptionPackageRepository = $subscriptionPackageRepository;
//        $this->messageBusHandler             = $messageBusHandler;
//        $this->entityTranslationCreator      = $entityTranslationCreator;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'DESC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('export');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'slug', 'PAGE_ENTITY.LABEL.SLUG');
        $this->configureFilterFieldText($filter, 'translations.title', 'PAGE_ENTITY.LABEL.TITLE');
        $this->configureFilterFieldText($filter, 'translations.content', 'PAGE_ENTITY.LABEL.CONTENT');
        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'slug',
                'url',
                [
                    'label'        => 'PAGE_ENTITY.LABEL.SLUG',
                    'header_style' => 'width:170px;',
                    'attributes'   => ['target' => '_blank'],
                    'template'     => 'admin/CRUD/page/list_url_page_entity.html.twig',
                ]
            );

        $this->configureListFieldText(
            $list,
            'translate.title',
            'PAGE_ENTITY.LABEL.TITLE',
            ['identifier' => true, 'route' => ['name' => 'edit']]
        );

        $activeOptions = ['editable' => $this->getModelClass() !== SystemPage::class];
        $this->configureListFieldActive($list, null, null, $activeOptions);

        $this->configureListFieldCreatedAt($list);
        $this->configureListFieldUpdatedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $this->configureFormSectionContent($form);

        if ($this->getSubject() instanceof CommonPage) {
            $this->configureFormSectionPermissions($form, 'col-md-3');
        }

        $this->configureFormSectionSettings($form);
        $this->configureFormSectionSitemap($form);
        $this->configureFormSectionCodeBlock($form);
    }

    protected function configureFormSectionContent(FormMapper $form): void
    {
        $page           = $this->getSubject();
        $slugIsReadonly = $page && ($page instanceof SystemPage || $page->isHomepage());
        $form->with('PAGE_ENTITY.SECTION.CONTENT', ['class' => 'col-md-9']);
        $form
            ->add(
                'slug',
                TextType::class,
                [
                    'label'       => 'PAGE_ENTITY.LABEL.SLUG',
                    'required'    => false,
                    'attr'        => ['readonly' => $slugIsReadonly],
                    'constraints' => [
                        new Callback([$this, 'validateUniqueSlug']),
                        $page instanceof SystemPage ? new Regex('/^[a-z0-9-\/]+$/') : new Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/'),
                    ],
                ]
            )
            ->add(
                'translations',
                TranslationsType::class,
                [
                    'label'          => $this->trans('PAGE_ENTITY.LABEL.TRANSLATIONS'),
                    'default_locale' => $this->parameterBag->get('default_locale'),
                    'locale_labels'  => $this->localeProvider->getLocaleTitlesForAdmin(),
                    'fields'         => [
                        'title' => [
                            'field_type'         => TextType::class,
                            'label'              => 'PAGE_ENTITY.LABEL.TITLE',
                            'help'               => 'PAGE_ENTITY.HELP.TITLE',
                            'required'           => true,
                            'translation_domain' => $this->getTranslationDomain(),
                            'locale_options'     => [
                                $this->localeProvider->getWebOrDefaultLocale() => [
                                    'constraints' => [
                                        new NotBlank(),
                                    ],
                                ],
                            ],
                        ],
                        'content' => [
                            'field_type'         => CKEditorType::class,
                            'label'              => 'PAGE_ENTITY.LABEL.CONTENT',
                            'help'               => 'PAGE_ENTITY.HELP.CONTENT',
                            'required'           => true,
                            'config_name'        => self::CK_EDITOR_CMS_CONFIG,
                            'trim'               => true,
                            'config'             => [],
                            'translation_domain' => $this->getTranslationDomain(),
                        ],
                        // meta
                        'metaTitle' => [
                            'field_type'         => TextType::class,
                            'label'              => 'META.LABEL.META_TITLE',
                            'help'               => 'META.HELP.META_TITLE',
                            'required'           => false,
                            'translation_domain' => $this->getTranslationDomain(),
                        ],
                        'metaKeywords' => [
                            'field_type'         => TextType::class,
                            'label'              => 'META.LABEL.META_KEYWORDS',
                            'help'               => 'META.HELP.META_KEYWORDS',
                            'required'           => false,
                            'translation_domain' => $this->getTranslationDomain(),
                        ],
                        'metaDescription' => [
                            'field_type'         => TextType::class,
                            'label'              => 'META.LABEL.META_DESCRIPTION',
                            'help'               => 'META.HELP.META_DESCRIPTION',
                            'required'           => false,
                            'translation_domain' => $this->getTranslationDomain(),
                        ],
                        'ogTitle' => [
                            'field_type'         => TextType::class,
                            'label'              => 'META.LABEL.OG_TITLE',
                            'help'               => 'META.HELP.OG_TITLE',
                            'required'           => false,
                            'translation_domain' => $this->getTranslationDomain(),
                        ],
                        'ogDescription' => [
                            'field_type'         => TextType::class,
                            'label'              => 'META.LABEL.OG_DESCRIPTION',
                            'help'               => 'META.HELP.OG_DESCRIPTION',
                            'required'           => false,
                            'translation_domain' => $this->getTranslationDomain(),
                        ],
                        'ogImage' => [
                            'field_type'         => ElFinderType::class,
                            'label'              => 'META.LABEL.OG_IMAGE',
                            'help'               => 'META.HELP.OG_IMAGE',
                            'required'           => false,
                            'instance'           => 'form',
                            'attr'               => ['class' => 'form-control'],
                            'enable'             => true,
                            'translation_domain' => $this->getTranslationDomain(),
                        ],
                        'redirect' => [
                            'field_type'         => TextType::class,
                            'label'              => 'PAGE_ENTITY.LABEL.REDIRECT',
                            'help'               => 'PAGE_ENTITY.HELP.REDIRECT',
                            'required'           => false,
                            'translation_domain' => $this->getTranslationDomain(),
                            'constraints'        => [
                                new Url(),
                            ],
                        ],
                    ],
                    'excluded_fields' => ['createdAt', 'updatedAt'],
                ]
            );

        $form->end();
    }

    protected function configureFormSectionSettings(FormMapper $form): void
    {
        $form->with('PAGE_ENTITY.SECTION.SETTINGS', ['class' => 'col-md-3']);
        $this->configureFormSettingsFields($form);
        $form->end();
    }

    protected function configureFormSettingsFields(FormMapper $form): void
    {
        $this->configureFormFieldActive($form);

        if ($this->getSubject() instanceof SystemPage) {
            $form->get('active')->setDisabled(true);
        }
    }

    protected function configureFormSectionSitemap(FormMapper $form): void
    {
        $form->with('PAGE_ENTITY.SECTION.INDEXING', ['class' => 'col-md-3']);

        $form->add(
            'indexed',
            ChoiceFieldMaskType::class,
            [
                'required'           => true,
                'label'              => 'PAGE_ENTITY.LABEL.INDEXED',
                'choices'            => self::$choicesYesNo,
                'translation_domain' => $this->getTranslationDomain(),
                'map'                => [
                    1 => ['sitemapChangeFrequency', 'sitemapPriority'],
                    0 => [],
                ],
            ],
        );

        $form
            ->add(
                'sitemapChangeFrequency',
                ChoiceType::class,
                [
                    'required'           => true,
                    'label'              => 'PAGE_ENTITY.LABEL.CHANGE_FREQUENCY',
                    'choices'            => self::SITEMAP_CHANGE_FREQUENCY_CHOICES,
                    'translation_domain' => $this->getTranslationDomain(),
                ],
            )
            ->add(
                'sitemapPriority',
                ChoiceType::class,
                [
                    'required'           => true,
                    'label'              => 'PAGE_ENTITY.LABEL.PRIORITY',
                    'choices'            => self::SITEMAP_PRIORITY_CHOICES,
                    'translation_domain' => $this->getTranslationDomain(),
                ],
            );

        $form->end();
    }

    protected function configureFormSectionCodeBlock(FormMapper $form): void
    {
        $form->with('PAGE_ENTITY.SECTION.CODE_BLOCK');

        $this->configureFormFieldTextarea(
            $form,
            'codeBlock',
            'PAGE_ENTITY.LABEL.CODE_BLOCK',
            'PAGE_ENTITY.HELP.CODE_BLOCK',
            false,
            5
        );

        $form->end();
    }

    public function validateUniqueSlug(?string $value, ExecutionContextInterface $context): void
    {
        if ($value === null) {
            return;
        }

        $page = $this->pageRepository->findOneBySlug($value);

        if ($page !== null
            && $this->getSubject() !== null
            && $page->getId() !== $this->getSubject()->getId()
        ) {
            $context
                ->buildViolation('PAGE_ENTITY.ERROR.SLUG_TAKEN')
                ->setParameter('%SLUG%', $value)
                ->setTranslationDomain($this->getTranslationDomain())
                ->atPath('slug')->addViolation();
        }
    }

    protected function postPersist(object $object): void
    {
        //$this->createEntityTranslations($object);
    }

    protected function postUpdate(object $object): void
    {
//        if ($object instanceof CommonPage) {
//            $this->messageBusHandler->handleCommand(new ResetPagePermissionsCommand($object->getId()));
//        }

        //$this->createEntityTranslations($object);
    }
}
