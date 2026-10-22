<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Traits\ConfigureAdminFullTrait;
use App\DTOFactory\Entity\BannerDTOFactory;
use App\Entity\Banner;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * @method Banner|null getSubject()
 */
class BannerAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

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
        $this->configureFilterFieldText($filter, 'name', 'BANNER_ENTITY.LABEL.NAME');
        $this->configureFilterFieldText($filter, 'alt', 'BANNER_ENTITY.LABEL.ALT');

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

        $this->configureListFieldText($list, 'name', 'BANNER_ENTITY.LABEL.NAME');
        $this->configureListFieldText($list, 'alt', 'BANNER_ENTITY.LABEL.ALT');
        $this->configureListFieldLinkEntity($list, 'linkUrl');

        $this->configureListFieldActive($list);
        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('BANNER_ENTITY.SECTION.MAIN');

        $form->add(
            'name',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'BANNER_ENTITY.LABEL.NAME',
                'help'               => 'BANNER_ENTITY.HELP.NAME',
                'constraints'        => [],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'alt',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'BANNER_ENTITY.LABEL.ALT',
                'help'               => 'BANNER_ENTITY.HELP.ALT',
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $this->configureFormFieldPosition($form, 'priority', 'BANNER_ENTITY.LABEL.PRIORITY', 'BANNER_ENTITY.HELP.PRIORITY');

        $theme       = $this->getSubject()?->getSite()?->getSiteTheme()?->getCode();
        $desktopSize = BannerDTOFactory::DESKTOP_SIZE[$theme] ?? BannerDTOFactory::DESKTOP_SIZE['default'];
        $mobileSize  = BannerDTOFactory::MOBILE_SIZE[$theme] ?? BannerDTOFactory::MOBILE_SIZE['default'];

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
