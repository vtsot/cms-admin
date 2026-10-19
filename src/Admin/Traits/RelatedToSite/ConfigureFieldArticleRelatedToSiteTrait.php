<?php

declare(strict_types=1);

namespace App\Admin\Traits\RelatedToSite;

use App\Admin\AbstractAdmin;
use App\Entity\Site\Site;
use App\Exception\AppException;
use App\Repository\Page\ArticleRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Contracts\Service\Attribute\Required;

use function sprintf;

trait ConfigureFieldArticleRelatedToSiteTrait
{
    private ArticleRepository $articleRepository;

    #[Required]
    public function initConfigureFieldArticleRelatedToSiteTrait(
        ArticleRepository $articleRepository,
    ): void {
        $this->articleRepository = $articleRepository;
    }

    protected function configureFilterFieldArticleRelatedToSite(
        DatagridMapper $filter,
        ?string $name = null,
        ?array $options = [],
        ?CallbackChoiceLoader $articleChoiceLoader = null,
    ): void {
        $this->buildConfigureFieldArticleRelatedToSite($filter, $name, $options, $articleChoiceLoader);
    }

    protected function configureFormFieldArticleRelatedToSite(
        FormMapper $form,
        ?string $name = null,
        ?array $options = [],
        ?CallbackChoiceLoader $articleChoiceLoader = null,
    ): void {
        $this->buildConfigureFieldArticleRelatedToSite($form, $name, $options, $articleChoiceLoader);
    }

    private function buildConfigureFieldArticleRelatedToSite(
        FormMapper|DatagridMapper $form,
        ?string $name = null,
        ?array $options = [],
        ?CallbackChoiceLoader $articleChoiceLoader = null,
    ): void {
        $name ??= 'article';

        /** @var AbstractAdmin $this */
        /** @var AbstractAdmin $admin */
        $admin    = $this->getRootAncestor();
        $objectId = $this->getRequest()->get($admin->getIdParameter());
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

        if ($articleChoiceLoader === null) {
            $articleChoiceLoader = new CallbackChoiceLoader(
                fn () => $this->articleRepository->getChoiceListBySiteId($site->getId())
            );
        }

        // resolve DatagridMapper
        if ($form instanceof DatagridMapper) {
            $form->add(
                $name,
                ChoiceFilter::class,
                array_merge(
                    [
                        'field_type'    => ChoiceType::class,
                        'field_options' => [
                            'choice_loader'      => $articleChoiceLoader,
                            'translation_domain' => $this->getTranslationDomain(),
                        ],
                    ], $options
                ),
                [
                    'admin_code' => 'admin.site.page.related_article.inline',
                ]
            );

            return;
        }

        // resolve FormMapper
        $form->add(
            $name,
            ModelType::class,
            array_merge(
                [
                    'attr'          => ['data-sonata-select2-allow-clear' => 'true'],
                    'required'      => $options['required'] ?? false,
                    'btn_add'       => false,
                    'empty_data'    => [],
                    'multiple'      => false,
                    'choice_loader' => $articleChoiceLoader,
                ], $options,
            ),
            [
                'admin_code' => 'admin.site.page.related_article.inline',
            ],
        );
    }
}
