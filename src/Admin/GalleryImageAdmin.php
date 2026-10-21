<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Traits\ConfigureAdminFullTrait;
use App\DTOFactory\Entity\GalleryImageDTOFactory;
use App\Entity\GalleryImage;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * @method GalleryImage|null getSubject()
 */
class GalleryImageAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    public const IMAGE_DOWNLOAD_WIDTH  = 9999;
    public const IMAGE_DOWNLOAD_HEIGHT = 9999;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'position',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'title', 'GALLERY_IMAGE_ENTITY.LABEL.TITLE');
        $this->configureFilterFieldText($filter, 'alt', 'GALLERY_IMAGE_ENTITY.LABEL.ALT');
        $this->configureFilterFieldText($filter, 'color', 'GALLERY_IMAGE_ENTITY.LABEL.COLOR');
        $this->configureFilterFieldText($filter, 'shape', 'GALLERY_IMAGE_ENTITY.LABEL.SHAPE');
        $this->configureFilterFieldText($filter, 'imprint', 'GALLERY_IMAGE_ENTITY.LABEL.IMPRINT');
        $this->configureFilterFieldText($filter, 'content', 'GALLERY_IMAGE_ENTITY.LABEL.CONTENT');
        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldPosition($list);

        $this->configureListFieldText(
            $list,
            'image',
            'GALLERY_IMAGE_ENTITY.LABEL.IMAGE',
            [
                'template' => '/admin/CRUD/gallery-image/list_image.html.twig',
                'data'     => [
                    'imageRouteName' => 'general.image',
                    'imageType'      => 'gallery',
                    'downloadWidth'  => static::IMAGE_DOWNLOAD_WIDTH,
                    'downloadHeight' => static::IMAGE_DOWNLOAD_HEIGHT,
                ],
            ],
        );

        $this->configureListFieldText($list, 'title', 'GALLERY_IMAGE_ENTITY.LABEL.TITLE');
        $this->configureListFieldText($list, 'alt', 'GALLERY_IMAGE_ENTITY.LABEL.ALT');
        $this->configureListFieldText($list, 'color', 'GALLERY_IMAGE_ENTITY.LABEL.COLOR');
        $this->configureListFieldText($list, 'shape', 'GALLERY_IMAGE_ENTITY.LABEL.SHAPE');
        $this->configureListFieldText($list, 'imprint', 'GALLERY_IMAGE_ENTITY.LABEL.IMPRINT');
        $this->configureListFieldLinkEntity($list, 'linkUrl');

        $this->configureListFieldActive($list);
        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('GALLERY_IMAGE_ENTITY.SECTION.MAIN');

        $form->add(
            'title',
            TextType::class,
            [
                'required'    => true,
                'label'       => 'GALLERY_IMAGE_ENTITY.LABEL.TITLE',
                'help'        => 'GALLERY_IMAGE_ENTITY.HELP.TITLE',
                'constraints' => [
                    new NotBlank(),
                ],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'alt',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'GALLERY_IMAGE_ENTITY.LABEL.ALT',
                'help'               => 'GALLERY_IMAGE_ENTITY.HELP.ALT',
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $theme     = $this->getSubject()?->getSite()?->getSiteTheme()?->getCode();
        $imageSize = GalleryImageDTOFactory::THUMBNAIL_SIZE[$theme] ?? GalleryImageDTOFactory::THUMBNAIL_SIZE['default'];

        $isRequiredImage = !($this->getSubject() && $this->getSubject()->getImage());
        $form->add('imageFile',
            VichImageType::class,
            [
                'label'              => 'GALLERY_IMAGE_ENTITY.LABEL.IMAGE',
                'help'               => 'GALLERY_IMAGE_ENTITY.HELP.IMAGE',
                'download_label'     => 'GALLERY_IMAGE_ENTITY.LABEL.IMAGE_DOWNLOAD',
                'required'           => $isRequiredImage,
                'allow_delete'       => false,
                'image_uri'          => $this->getImageUrl($this->getSubject(), 'resize', $imageSize['width'], $imageSize['height']) ?: false,
                'download_uri'       => $this->getImageUrl($this->getSubject(), 'resize', static::IMAGE_DOWNLOAD_WIDTH, static::IMAGE_DOWNLOAD_HEIGHT) ?: false,
                'translation_domain' => $this->getTranslationDomain(),
                'constraints'        => $isRequiredImage ? [new NotBlank()] : [],
            ],
        );

        $form->add(
            'color',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'GALLERY_IMAGE_ENTITY.LABEL.COLOR',
                'help'               => 'GALLERY_IMAGE_ENTITY.HELP.COLOR',
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'shape',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'GALLERY_IMAGE_ENTITY.LABEL.SHAPE',
                'help'               => 'GALLERY_IMAGE_ENTITY.HELP.SHAPE',
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'imprint',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'GALLERY_IMAGE_ENTITY.LABEL.IMPRINT',
                'help'               => 'GALLERY_IMAGE_ENTITY.HELP.IMPRINT',
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $this->configureFormFieldTextarea(
            $form,
            'content',
            'GALLERY_IMAGE_ENTITY.LABEL.CONTENT',
            'GALLERY_IMAGE_ENTITY.HELP.CONTENT',
            false,
            4,
        );

        $this->configureFormFieldLinkEntity($form);

        $form->end();
    }

    private function getImageUrl(?GalleryImage $galleryImage, string $crop, int $width, int $height): ?string
    {
        return $galleryImage !== null && $galleryImage->getImage()
            ? $this->routeGenerator->generate(
                'general.image',
                [
                    'type'   => 'gallery',
                    'crop'   => $crop,
                    'width'  => $width,
                    'height' => $height,
                    'image'  => $galleryImage->getImage(),
                ]
            )
            : null;
    }
}
