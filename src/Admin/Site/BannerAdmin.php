<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureFilterTrait;
use App\Admin\Traits\ConfigureListTrait;
use App\Admin\Traits\RelatedToSite\ConfigureFormFieldLinkEntityRelatedToSiteTrait;
use App\DTOFactory\Entity\Site\BannerDTOFactory;
use App\Entity\Site\Banner;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * @method Banner|null getSubject()
 */
class BannerAdmin extends AbstractAdmin
{
    use ConfigureFilterTrait;
    use ConfigureListTrait;
    use ConfigureFormFieldLinkEntityRelatedToSiteTrait;

    public const int IMAGE_DOWNLOAD_WIDTH  = 9999;
    public const int IMAGE_DOWNLOAD_HEIGHT = 9999;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'DESC',
            '_sort_by'    => 'priority',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldTranslation($filter, 'title', 'BANNER_ENTITY.LABEL.TITLE');
        $this->configureFilterFieldTranslation($filter, 'imageAlt', 'BANNER_ENTITY.LABEL.IMAGE_ALT');

        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldPosition($list, 'priority', 'BANNER_ENTITY.LABEL.PRIORITY');

        $this->configureListFieldText(
            $list,
            'banner_image_virtual',
            'BANNER_ENTITY.LABEL.BANNER',
            [
                'virtual_field' => true,
                'template'      => '/admin/CRUD/banner/list_banner_image.html.twig',
                'data'          => [
                    'imageRouteName' => 'general.image',
                    'imageType'      => 'banner',
                    'downloadWidth'  => static::IMAGE_DOWNLOAD_WIDTH,
                    'downloadHeight' => static::IMAGE_DOWNLOAD_HEIGHT,
                ],
            ],
        );

        $this->configureListFieldText($list, 'title', 'BANNER_ENTITY.LABEL.TITLE');
        $this->configureListFieldText($list, 'imageAlt', 'BANNER_ENTITY.LABEL.IMAGE_ALT');
        $this->configureListFieldLinkEntity($list, 'linkUrl');

        $this->configureListFieldActive($list);
        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $title = $this->transLocaleTitle('BANNER_ENTITY.SECTION.MAIN');
        $form->with($title, ['label' => $title]);

        $form->add(
            'title',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'BANNER_ENTITY.LABEL.TITLE',
                'help'               => 'BANNER_ENTITY.HELP.TITLE',
                'constraints'        => [],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'imageAlt',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'BANNER_ENTITY.LABEL.IMAGE_ALT',
                'help'               => 'BANNER_ENTITY.HELP.IMAGE_ALT',
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $this->configureFormFieldPosition($form, 'priority', 'BANNER_ENTITY.LABEL.PRIORITY', 'BANNER_ENTITY.HELP.PRIORITY');

        // $theme       = $this->getSubject()?->getSite()?->getSiteTheme()?->getCode();
        $desktopSize = BannerDTOFactory::DESKTOP_SIZE['default'];
        $mobileSize  = BannerDTOFactory::MOBILE_SIZE['default'];

        $desktopImage           = $this->getSubject()?->getDesktopImage();
        $isRequiredDesktopImage = !$desktopImage;
        $form->add(
            'desktopImageFile',
            VichImageType::class,
            [
                'label'                       => 'BANNER_ENTITY.LABEL.DESKTOP_IMAGE',
                'help'                        => 'BANNER_ENTITY.HELP.DESKTOP_IMAGE',
                'help_translation_parameters' => ['%SIZE%' => $desktopSize['width'] . 'x' . $desktopSize['height']],
                'download_label'              => 'BANNER_ENTITY.LABEL.IMAGE_DOWNLOAD',
                'required'                    => false, // $isRequiredDesktopImage,
                'allow_delete'                => true,
                'image_uri'                   => $this->getImageUrl($desktopImage, 'resize', $desktopSize['width'], $desktopSize['height']) ?: false,
                'download_uri'                => $this->getImageUrl($desktopImage, 'resize', static::IMAGE_DOWNLOAD_WIDTH, static::IMAGE_DOWNLOAD_HEIGHT) ?: false,
                'translation_domain'          => $this->getTranslationDomain(),
                // 'constraints'                 => $isRequiredDesktopImage ? [new NotBlank()] : [],
            ],
        );

        $mobileImage           = $this->getSubject()?->getMobileImage();
        $isRequiredMobileImage = !$mobileImage;
        $form->add(
            'mobileImageFile',
            VichImageType::class,
            [
                'label'                       => 'BANNER_ENTITY.LABEL.MOBILE_IMAGE',
                'help'                        => 'BANNER_ENTITY.HELP.MOBILE_IMAGE',
                'help_translation_parameters' => ['%SIZE%' => $mobileSize['width'] . 'x' . $mobileSize['height']],
                'download_label'              => 'BANNER_ENTITY.LABEL.IMAGE_DOWNLOAD',
                'required'                    => false, // $isRequiredMobileImage,
                'allow_delete'                => true,
                'image_uri'                   => $this->getImageUrl($mobileImage, 'resize', $mobileSize['width'], $mobileSize['height']) ?: false,
                'download_uri'                => $this->getImageUrl($mobileImage, 'resize', static::IMAGE_DOWNLOAD_WIDTH, static::IMAGE_DOWNLOAD_WIDTH) ?: false,
                'translation_domain'          => $this->getTranslationDomain(),
                // 'constraints'                 => $isRequiredMobileImage ? [new NotBlank()] : [],
            ],
        );

        $this->configureFormFieldLinkEntity($form);

        $form->end();
    }

    private function getImageUrl(?string $bannerImageName, string $crop, int $width, int $height): ?string
    {
        return $bannerImageName
            ? $this->routeGenerator->generate(
                'general.image',
                [
                    'type'   => 'banner',
                    'crop'   => $crop,
                    'width'  => $width,
                    'height' => $height,
                    'image'  => $bannerImageName,
                ]
            )
            : null;
    }
}
