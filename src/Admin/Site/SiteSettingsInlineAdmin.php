<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\DTOFactory\Entity\Site\SiteSettingsDTOFactory;
use App\Entity\Site\SiteSettings;
use App\Repository\Page\ArticleRepository;
use App\Repository\Page\PageRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Contracts\Service\Attribute\Required;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * @method SiteSettings|null getSubject()
 */
class SiteSettingsInlineAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    public const int IMAGE_DOWNLOAD_WIDTH  = 9999;
    public const int IMAGE_DOWNLOAD_HEIGHT = 9999;

    protected PageRepository $pageRepository;
    protected ArticleRepository $articleRepository;

    #[Required]
    public function initDependencies(
        PageRepository $pageRepository,
        ArticleRepository $articleRepository,
    ): void {
        $this->pageRepository    = $pageRepository;
        $this->articleRepository = $articleRepository;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $faviconImage = $this->getSubject()?->getFavicon();
        $form->add(
            'faviconFile',
            VichImageType::class,
            [
                'label'                       => 'SITE_SETTINGS_ENTITY.LABEL.FAVICON',
                'help'                        => 'SITE_SETTINGS_ENTITY.HELP.FAVICON',
                'help_translation_parameters' => ['%SIZE%' => '16x16'],
                'download_label'              => 'SITE_SETTINGS_ENTITY.LABEL.IMAGE_DOWNLOAD',
                'required'                    => false,
                'allow_delete'                => true,
                'delete_label'                => 'SITE_SETTINGS_ENTITY.LABEL.FAVICON_DELETE',
                'image_uri'                   => $this->getFaviconUrl($faviconImage) ?: false,
                'download_uri'                => $this->getFaviconUrl($faviconImage) ?: false,
                'translation_domain'          => $this->getTranslationDomain(),
                'constraints'                 => [],
                'attr'                        => ['width' => '64px', 'height' => '64px', 'no-download' => true],
            ],
        );

        $this->configureFormFieldText(
            $form,
            'imageAlt',
            'SITE_SETTINGS_ENTITY.LABEL.IMAGE_ALT',
            'SITE_SETTINGS_ENTITY.HELP.IMAGE_ALT',
        );

        $desktopSize = SiteSettingsDTOFactory::DESKTOP_SIZE['default'];
        $mobileSize  = SiteSettingsDTOFactory::MOBILE_SIZE['default'];

        $desktopImage = $this->getSubject()?->getDesktopImage();
        $form->add(
            'desktopImageFile',
            VichImageType::class,
            [
                'label'                       => 'SITE_SETTINGS_ENTITY.LABEL.DESKTOP_IMAGE',
                'help'                        => 'SITE_SETTINGS_ENTITY.HELP.DESKTOP_IMAGE',
                'help_translation_parameters' => ['%SIZE%' => $desktopSize['width'] . 'x' . $desktopSize['height']],
                'download_label'              => 'SITE_SETTINGS_ENTITY.LABEL.IMAGE_DOWNLOAD',
                'required'                    => false,
                'allow_delete'                => true,
                'delete_label'                => 'SITE_SETTINGS_ENTITY.LABEL.DESKTOP_IMAGE_DELETE',
                'image_uri'                   => $this->getImageUrl($desktopImage, 'resize', $desktopSize['width'], $desktopSize['height']) ?: false,
                'download_uri'                => $this->getImageUrl($desktopImage, 'resize', static::IMAGE_DOWNLOAD_WIDTH, static::IMAGE_DOWNLOAD_HEIGHT) ?: false,
                'translation_domain'          => $this->getTranslationDomain(),
                'constraints'                 => [],
            ],
        );

        $mobileImage = $this->getSubject()?->getMobileImage();
        $form->add(
            'mobileImageFile',
            VichImageType::class,
            [
                'label'                       => 'SITE_SETTINGS_ENTITY.LABEL.MOBILE_IMAGE',
                'help'                        => 'SITE_SETTINGS_ENTITY.HELP.MOBILE_IMAGE',
                'help_translation_parameters' => ['%SIZE%' => $mobileSize['width'] . 'x' . $mobileSize['height']],
                'download_label'              => 'SITE_SETTINGS_ENTITY.LABEL.IMAGE_DOWNLOAD',
                'required'                    => false,
                'allow_delete'                => true,
                'delete_label'                => 'SITE_SETTINGS_ENTITY.LABEL.MOBILE_IMAGE_DELETE',
                'image_uri'                   => $this->getImageUrl($mobileImage, 'resize', $mobileSize['width'], $mobileSize['height']) ?: false,
                'download_uri'                => $this->getImageUrl($mobileImage, 'resize', static::IMAGE_DOWNLOAD_WIDTH, static::IMAGE_DOWNLOAD_WIDTH) ?: false,
                'translation_domain'          => $this->getTranslationDomain(),
                'constraints'                 => [],
            ],
        );
    }

    private function getFaviconUrl(?string $imageName): ?string
    {
        return $imageName
            ? $this->routeGenerator->generate('general.image.favicon', ['image' => $imageName])
            : null;
    }

    private function getImageUrl(?string $imageName, string $crop, int $width, int $height): ?string
    {
        return $imageName
            ? $this->routeGenerator->generate(
                'general.image',
                [
                    'type'   => 'site',
                    'crop'   => $crop,
                    'width'  => $width,
                    'height' => $height,
                    'image'  => $imageName,
                ]
            )
            : null;
    }
}
