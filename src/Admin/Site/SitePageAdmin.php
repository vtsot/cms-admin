<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\Content\AbstractPageAdmin;
use App\Entity\Page\Page;
use App\Exception\AppException;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @method Page|null getSubject()
 */
class SitePageAdmin extends AbstractPageAdmin
{
    protected function getAccessMapping(): array
    {
        return [
            'make-homepage' => 'MAKE_HOMEPAGE',
        ];
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection->add('make-homepage', $this->getRouterIdParameter() . '/make-homepage');
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

        $this->configureListFieldEnum(
            $list,
            'homepage',
            'PAGE_ENTITY.LABEL.HOMEPAGE',
            [
                'template'     => 'admin/CRUD/page/list__homepage_boolean.html.twig',
                'header_style' => 'width:100px;',
            ],
        );

        $this->configureListFieldChangedAt($list);

        $this->configureListFieldText(
            $list,
            'makeHomepage',
            'PAGE_ENTITY.LABEL.MAKE_HOMEPAGE',
            [
                'virtual_field' => true,
                'sortable'      => false,
                'template'      => 'admin/CRUD/page/list__action_make-homepage.html.twig',
                'header_style'  => 'width:130px;',
            ]
        );

        $actions = [
            'children' => ['template' => 'admin/CRUD/list__action_children.html.twig'],
            'edit'     => [],
            'delete'   => ['template' => 'admin/CRUD/page/list__action_delete.html.twig'],
        ];
        $this->configureListFieldActions(list: $list, actions: $actions);
    }

    protected function prePersist(object $object): void
    {
        /** @var Page $object */
        $this->attemptToSetHomepageAutomatically($object);
    }

    protected function preUpdate(object $object): void
    {
        /** @var Page $object */
        if ($object->isHomepage() && !$object->isActive()) {
            throw new AppException('Homepage cannot be deactivated');
        }

        /** @var Page $object */
        $this->attemptToSetHomepageAutomatically($object);
    }

    private function attemptToSetHomepageAutomatically(Page $object): void
    {
        if ($object->isActive()
            && $object->getSite()
            && !$this->pageRepository->findHomepageBySiteId($object->getSite()->getId())) {
            // currently no homepage => set this page as homepage
            $object->setHomepage(true);
        }
    }

    protected function preRemove(object $object): void
    {
        /** @var Page $object */
        if ($object->isHomepage()) {
            throw new AppException('Homepage cannot be deleted');
        }
    }

    public function preBatchAction(
        string $actionName,
        ProxyQueryInterface $query,
        array &$idx,
        bool $allElements = false,
    ): void {
        if ($actionName === 'delete') {
            /** @var ProxyQueryInterface|QueryBuilder $query */
            $alias = current($query->getRootAliases());

            // exclude homepage
            $query
                ->andWhere("{$alias}.homepage = :is_homepage")
                ->setParameter('is_homepage', false);
        }
    }

    protected function configureFormFields(FormMapper $form): void
    {
        // see parent::configureFormFields($form); added configureFormSectionRelatedArticles
        $this->configureFormSectionContent($form);
        $this->configureFormSectionSettings($form);
        $this->configureFormSectionSitemap($form);
        $this->configureFormSectionRelatedArticles($form);
        $this->configureFormSectionSeo($form);
        $this->configureFormSectionCodeBlock($form);
    }

    private function configureFormSectionRelatedArticles(FormMapper $form): void
    {
        if ($form->has('relatedArticlesTitle')) {
            $form->remove('relatedArticlesTitle');
        }

        $form->with('PAGE_ENTITY.SECTION.RELATED_ARTICLES', ['class' => 'col-md-9']);

        $form->add(
            'relatedArticlesTitle',
            TextType::class,
            [
                'required' => false,
                'label'    => 'PAGE_ENTITY.LABEL.RELATED_ARTICLE_TITLE',
                'help'     => 'PAGE_ENTITY.HELP.RELATED_ARTICLE_TITLE',
            ],
        );

        $form->add(
            'relatedArticles',
            CollectionType::class,
            [
                'required'     => false,
                'label'        => 'PAGE_ENTITY.LABEL.RELATED_ARTICLES',
                'by_reference' => false,
                'type_options' => [
                    // Prevents the "Delete" option from being displayed
                    'delete' => true,
                ],
            ],
            [
                'admin_code' => 'admin.site.page.related_article.inline',
                'edit'       => 'inline',
                'inline'     => 'table',
            ],
        );

        $form->end();
    }
}
