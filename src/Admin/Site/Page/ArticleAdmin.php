<?php

declare(strict_types=1);

namespace App\Admin\Site\Page;

use App\Admin\Content\AbstractPageAdmin;
use App\DTOFactory\Entity\Page\ArticleDetailsDTOFactory;
use App\Entity\Page\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * @method Article|null getSubject()
 */
class ArticleAdmin extends AbstractPageAdmin
{
    public const int IMAGE_DOWNLOAD_WIDTH  = 9999;
    public const int IMAGE_DOWNLOAD_HEIGHT = 9999;

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'slug', 'PAGE_ENTITY.LABEL.SLUG');
        $this->configureFilterFieldTranslation($filter, 'title', 'PAGE_ENTITY.LABEL.TITLE');
        $this->configureFilterFieldTranslation($filter, 'imageAlt', 'ARTICLE_ENTITY.LABEL.IMAGE_ALT');
        $this->configureFilterFieldTranslation($filter, 'content', 'PAGE_ENTITY.LABEL.CONTENT');
        $this->configureFilterFieldTranslation($filter, 'description', 'PAGE_ENTITY.LABEL.DESCRIPTION');

        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText(
            $list,
            'article_image_virtual',
            'ARTICLE_ENTITY.LABEL.IMAGE',
            [
                'virtual_field' => true,
                'template'      => '/admin/CRUD/article/list_article_image.html.twig',
                'data'          => [
                    'imageRouteName' => 'general.image',
                    'imageType'      => 'article',
                    'downloadWidth'  => static::IMAGE_DOWNLOAD_WIDTH,
                    'downloadHeight' => static::IMAGE_DOWNLOAD_HEIGHT,
                ],
            ],
        );
        $this->configureListFieldText(
            $list,
            'title',
            'PAGE_ENTITY.LABEL.TITLE',
            ['identifier' => true, 'route' => ['name' => 'edit']],
        );

        $this->configureListFieldHtml(
            $list,
            'description',
            'PAGE_ENTITY.LABEL.DESCRIPTION',
        );

        $this->configureListFieldActive(
            list: $list,
            options: ['template' => 'admin/CRUD/page/list__active.html.twig'],
        );

        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormSectionContent(FormMapper $form): void
    {
        $page           = $this->getSubject();
        $slugIsReadonly = $page && $page->isHomepage();
        $form->with($this->trans('PAGE_ENTITY.SECTION.CONTENT'), ['class' => 'col-md-9']);

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
            'imageAlt',
            TextType::class,
            [
                'required'    => false,
                'label'       => 'ARTICLE_ENTITY.LABEL.IMAGE_ALT',
                'help'        => 'ARTICLE_ENTITY.HELP.IMAGE_ALT',
                'constraints' => [],
            ],
        );

        $desktopSize = ArticleDetailsDTOFactory::DESKTOP_SIZE['default'];

        $form->add('imageFile',
            VichImageType::class,
            [
                'label'                       => 'ARTICLE_ENTITY.LABEL.IMAGE',
                'help'                        => 'ARTICLE_ENTITY.HELP.IMAGE',
                'help_translation_parameters' => ['%SIZE%' => $desktopSize['width'] . 'x' . $desktopSize['height']],
                'download_label'              => 'ARTICLE_ENTITY.LABEL.IMAGE_DOWNLOAD',
                'required'                    => false,
                'allow_delete'                => false,
                'image_uri'                   => $this->getImageUrl($this->getSubject(), 'resize', $desktopSize['width'], $desktopSize['height']) ?: false,
                'download_uri'                => $this->getImageUrl($this->getSubject(), 'resize', static::IMAGE_DOWNLOAD_WIDTH, static::IMAGE_DOWNLOAD_HEIGHT) ?: false,
                'translation_domain'          => $this->getTranslationDomain(),
                'constraints'                 => [],
            ],
        );

        $form->add(
            'description',
            CKEditorType::class,
            [
                'required'    => false,
                'label'       => 'ARTICLE_ENTITY.LABEL.DESCRIPTION',
                'help'        => 'ARTICLE_ENTITY.HELP.DESCRIPTION',
                'config_name' => self::CK_EDITOR_BASE_CONFIG,
                'trim'        => true,
                'config'      => ['height' => 150],
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

    private function getImageUrl(?Article $article, string $crop, int $width, int $height): ?string
    {
        return $article !== null && $article->getImage()
            ? $this->routeGenerator->generate(
                'general.image',
                [
                    'type'   => 'article',
                    'crop'   => $crop,
                    'width'  => $width,
                    'height' => $height,
                    'image'  => $article->getImage(),
                ]
            )
            : null;
    }
}
