<?php

declare(strict_types=1);

namespace App\Admin\Traits\RelatedToSite;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureFormTrait;
use App\Entity\Site\Site;
use App\Exception\AppException;
use App\Repository\Page\ArticleRepository;
use App\Repository\Page\PageRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Contracts\Service\Attribute\Required;

use function sprintf;

trait ConfigureFormFieldLinkEntityRelatedToSiteTrait
{
    use ConfigureFormTrait {
        configureFormFieldLinkEntity as baseConfigureFormFieldLinkEntity;
    }

    private PageRepository $pageRepository;
    private ArticleRepository $articleRepository;

    #[Required]
    public function initConfigureFormFieldLinkEntityRelatedToSiteTrait(
        PageRepository $pageRepository,
        ArticleRepository $articleRepository,
    ): void {
        $this->pageRepository    = $pageRepository;
        $this->articleRepository = $articleRepository;
    }

    protected function configureFormFieldLinkEntity(
        FormMapper $form,
        ?string $fieldsPrefix = null,
        ?array $labels = [],
        ?CallbackChoiceLoader $pageChoiceLoader = null,
        ?CallbackChoiceLoader $articleChoiceLoader = null,
        ?array $context = [],
    ): void {
        /** @var AbstractAdmin $this */
        /** @var AbstractAdmin $admin */
        $admin    = $this->getRootAncestor();
        $objectId = $this->getRequest()->attributes->get($admin->getIdParameter());
        $site     = $admin->getObject($objectId);

        if (!$site instanceof Site) {
            throw new AppException(
                sprintf(
                    'Unable to find %s object with id: %s.',
                    $admin->getClassnameLabel(),
                    $objectId
                )
            );
        }

        if ($pageChoiceLoader === null) {
            $pageChoiceLoader = new CallbackChoiceLoader(
                fn () => $this->pageRepository->getChoiceListBySiteId($site->getId())
            );
        }

        if ($articleChoiceLoader === null) {
            $articleChoiceLoader = new CallbackChoiceLoader(
                fn () => $this->articleRepository->getChoiceListBySiteId($site->getId())
            );
        }

        $this->baseConfigureFormFieldLinkEntity(
            $form,
            $fieldsPrefix,
            $labels,
            $pageChoiceLoader,
            $articleChoiceLoader,
            $context,
        );
    }
}
