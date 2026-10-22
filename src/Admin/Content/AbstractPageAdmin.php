<?php

declare(strict_types=1);

namespace App\Admin\Content;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Page\AbstractPage;
use App\Repository\Page\AbstractPageRepository;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * @method AbstractPage|null getSubject()
 */
class AbstractPageAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    protected AbstractPageRepository $pageRepository;

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
    ): void {
        $this->pageRepository = $pageRepository;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'slug',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'slug', 'PAGE_ENTITY.LABEL.SLUG');
        $this->configureFilterFieldText($filter, 'title', 'PAGE_ENTITY.LABEL.TITLE');
        $this->configureFilterFieldText($filter, 'content', 'PAGE_ENTITY.LABEL.CONTENT');

        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText(
            $list,
            'title',
            'PAGE_ENTITY.LABEL.TITLE',
            ['identifier' => true, 'route' => ['name' => 'edit']],
        );

        $this->configureListFieldActive(
            list: $list,
            options: ['template' => 'admin/CRUD/page/list__active.html.twig'],
        );

        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $this->configureFormSectionContent($form);
        $this->configureFormSectionSettings($form);
        $this->configureFormSectionSitemap($form);
        $this->configureFormSectionSeo($form);
        $this->configureFormSectionCodeBlock($form);
    }

    protected function configureFormSectionContent(FormMapper $form): void
    {
        $page           = $this->getSubject();
        $slugIsReadonly = $page && $page->isHomepage();
        $form->with('PAGE_ENTITY.SECTION.CONTENT', ['class' => 'col-md-9']);

        $form->add(
            'slug',
            TextType::class,
            [
                'required'    => false,
                'label'       => 'PAGE_ENTITY.LABEL.SLUG',
                'attr'        => ['readonly' => $slugIsReadonly],
                'constraints' => [
                    new Callback([$this, 'validateUniqueSlug']),
                ],
            ],
        );

        $form->add(
            'title',
            TextType::class,
            [
                'required'    => false,
                'label'       => 'PAGE_ENTITY.LABEL.TITLE',
                'help'        => 'PAGE_ENTITY.HELP.TITLE',
                'constraints' => [new NotBlank()],
            ],
        );

        $form->add(
            'content',
            CKEditorType::class,
            [
                'required'    => false,
                'label'       => 'PAGE_ENTITY.LABEL.CONTENT',
                'help'        => 'PAGE_ENTITY.HELP.CONTENT',
                'config_name' => self::CK_EDITOR_CMS_CONFIG,
                'trim'        => true,
                'config'      => [],
            ],
        );

        //        $form->add(
        //            'relatedArticlesTitle',
        //            TextType::class,
        //            [
        //                'required' => false,
        //                'label'    => 'PAGE_ENTITY.LABEL.RELATED_ARTICLE_TITLE',
        //                'help'     => 'PAGE_ENTITY.HELP.RELATED_ARTICLE_TITLE',
        //            ],
        //        );

        $form->add(
            'sources',
            CKEditorType::class,
            [
                'required'    => false,
                'label'       => 'PAGE_ENTITY.LABEL.SOURCE',
                'help'        => 'PAGE_ENTITY.HELP.SOURCE',
                'config_name' => self::CK_EDITOR_BASE_CONFIG,
                'trim'        => true,
            ],
        );

        $form->end();
    }

    protected function configureFormSectionSeo(FormMapper $form): void
    {
        $form->with('PAGE_ENTITY.SECTION.SEO');

        $form->add(
            'metaTitle',
            TextType::class,
            [
                'required' => false,
                'label'    => 'META.LABEL.META_TITLE',
                'help'     => 'META.HELP.META_TITLE',
            ],
        );

        $form->add(
            'metaKeywords',
            TextType::class,
            [
                'required' => false,
                'label'    => 'META.LABEL.META_KEYWORDS',
                'help'     => 'META.HELP.META_KEYWORDS',
            ],
        );

        $form->add(
            'metaDescription',
            TextType::class,
            [
                'required' => false,
                'label'    => 'META.LABEL.META_DESCRIPTION',
                'help'     => 'META.HELP.META_DESCRIPTION',
            ],
        );

        $form->add(
            'ogTitle',
            TextType::class,
            [
                'required' => false,
                'label'    => 'META.LABEL.OG_TITLE',
                'help'     => 'META.HELP.OG_TITLE',
            ],
        );

        $form->add(
            'ogDescription',
            TextType::class,
            [
                'required' => false,
                'label'    => 'META.LABEL.OG_DESCRIPTION',
                'help'     => 'META.HELP.OG_DESCRIPTION',
            ],
        );

        $form->add(
            'ogImage',
            ElFinderType::class,
            [
                'required'           => false,
                'label'              => 'META.LABEL.OG_IMAGE',
                'help'               => 'META.HELP.OG_IMAGE',
                'instance'           => 'form',
                'attr'               => ['class' => 'form-control'],
                'enable'             => true,
                'translation_domain' => $this->getTranslationDomain(),
            ],
        );
        $form->end();
    }

    protected function configureFormSectionSettings(FormMapper $form): void
    {
        $form->with('PAGE_ENTITY.SECTION.SETTINGS', ['class' => 'col-md-3']);

        $this->configureFormFieldActive($form);

        $form->add(
            'redirect',
            TextType::class,
            [
                'required'    => false,
                'label'       => 'PAGE_ENTITY.LABEL.REDIRECT',
                'help'        => 'PAGE_ENTITY.HELP.REDIRECT',
                'constraints' => [new Url()],
            ],
        );

        $isReadonly = $this->getSubject() && $this->getSubject()->isHomepage();

        if ($isReadonly) {
            $form->get('active')->setDisabled(true);
            $form->get('redirect')->setDisabled(true);
        }

        $form->end();
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
            5,
        );

        $form->end();
    }

    public function validateUniqueSlug(?string $value, ExecutionContextInterface $context): void
    {
        if ($value === null) {
            return;
        }

        $siteId = $this->getSubject()?->getSite()?->getId();
        $page   = $siteId ? $this->pageRepository->findOneBySiteIdAndSlug($siteId, $value) : null;

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
}
