<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Contract\Dictionary\Site\SiteSettingsImagePosition;
use App\DTOFactory\Entity\Site\SiteThemeDTOFactory;
use App\Entity\Site\SiteSettings;
use App\Entity\Site\SiteTheme;
use App\Repository\Page\ArticleRepository;
use App\Repository\Page\PageRepository;
use App\Repository\Site\SiteThemeRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Service\Attribute\Required;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * @method SiteSettings|null getSubject()
 */
class SiteThemeSettingsInlineAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    public const IMAGE_DOWNLOAD_WIDTH  = 9999;
    public const IMAGE_DOWNLOAD_HEIGHT = 9999;

    protected PageRepository $pageRepository;
    protected ArticleRepository $articleRepository;
    protected SiteThemeRepository $siteThemeRepository;

    #[Required]
    public function initDependencies(
        PageRepository $pageRepository,
        ArticleRepository $articleRepository,
        SiteThemeRepository $siteThemeRepository,
    ): void {
        $this->pageRepository      = $pageRepository;
        $this->articleRepository   = $articleRepository;
        $this->siteThemeRepository = $siteThemeRepository;
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
        $themeChoices = $this->siteThemeRepository->getChoiceCodeList();
        $form->add(
            'theme',
            ChoiceFieldMaskType::class,
            [
                'required'           => true,
                'mapped'             => false,
                'label'              => 'SITE_ENTITY.LABEL.THEME',
                'help'               => 'SITE_ENTITY.HELP.THEME',
                'placeholder'        => 'SITE_ENTITY.PLACEHOLDER.THEME',
                'choices'            => $themeChoices,
                'translation_domain' => $this->getTranslationDomain(),
                'constraints'        => [new NotBlank()],
                'data'               => $this->getSubject()?->getSite()?->getSiteTheme()?->getCode(),
                'map'                => [
                    SiteTheme::THEME_REVIEW => [
                        'imagePosition',
                        'imageTitle',
                        'desktopImageFile',
                        'mobileImageFile',
                        'linkActive',
                        'linkTitle',
                        'linkType',
                        'linkPage',
                        'linkArticle',
                        'linkUrl',
                        'linkTarget',
                        'linkNoFollow',
                    ],
                ],
            ],
        );

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
            ],
        );

        $theme       = $this->getSubject()?->getSite()?->getSiteTheme()?->getCode();
        $desktopSize = SiteThemeDTOFactory::SITE_IMAGE_DESKTOP_SIZE[$theme] ?? SiteThemeDTOFactory::SITE_IMAGE_DESKTOP_SIZE['default'];
        $mobileSize  = SiteThemeDTOFactory::SITE_IMAGE_MOBILE_SIZE[$theme] ?? SiteThemeDTOFactory::SITE_IMAGE_MOBILE_SIZE['default'];

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

        $this->configureFormFieldEnum(
            $form,
            'imagePosition',
            SiteSettingsImagePosition::class,
            'SITE_SETTINGS_ENTITY.LABEL.IMAGE_POSITION',
            'SITE_SETTINGS_ENTITY.HELP.IMAGE_POSITION',
            false,
        );

        $this->configureFormFieldText(
            $form,
            'imageTitle',
            'SITE_SETTINGS_ENTITY.LABEL.IMAGE_TITLE',
            'SITE_SETTINGS_ENTITY.HELP.IMAGE_TITLE',
        );

        $this->configureFormFieldActive(
            $form,
            'linkActive',
            'SITE_SETTINGS_ENTITY.LABEL.LINK_ACTIVE',
            'SITE_SETTINGS_ENTITY.HELP.LINK_ACTIVE',
            true,
        );

        $this->configureFormFieldText(
            $form,
            'linkTitle',
            'SITE_SETTINGS_ENTITY.LABEL.LINK_TITLE',
            'SITE_SETTINGS_ENTITY.HELP.LINK_TITLE',
        );

        $site                = $this->getSubject()?->getSite();
        $pageChoiceLoader    = $site ? new CallbackChoiceLoader(fn () => $this->pageRepository->getChoiceListBySiteId($site->getId())) : null;
        $articleChoiceLoader = $site ? new CallbackChoiceLoader(fn () => $this->articleRepository->getChoiceListBySiteId($site->getId())) : null;

        $this->configureFormFieldLinkEntity(
            form: $form,
            labels: ['linkType' => 'SITE_SETTINGS_ENTITY.LABEL.LINK_TYPE'],
            pageChoiceLoader: $pageChoiceLoader,
            articleChoiceLoader: $articleChoiceLoader,
        );

        $this->configureFormFieldColor(
            $form,
            'themePrimaryColor',
            'SITE_SETTINGS_ENTITY.LABEL.THEME_PRIMARY_COLOR',
            'SITE_SETTINGS_ENTITY.HELP.THEME_COLOR',
        );

        $this->configureFormFieldColor(
            $form,
            'themeTextColor',
            'SITE_SETTINGS_ENTITY.LABEL.THEME_TEXT_COLOR',
            'SITE_SETTINGS_ENTITY.HELP.THEME_COLOR',
        );

        $this->configureFormFieldColor(
            $form,
            'themeTopBgColor',
            'SITE_SETTINGS_ENTITY.LABEL.THEME_TOP_BG_COLOR',
            'SITE_SETTINGS_ENTITY.HELP.THEME_COLOR',
        );

        $this->configureFormFieldColor(
            $form,
            'themeFooterBgColor',
            'SITE_SETTINGS_ENTITY.LABEL.THEME_FOOTER_BG_COLOR',
            'SITE_SETTINGS_ENTITY.HELP.THEME_COLOR',
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
