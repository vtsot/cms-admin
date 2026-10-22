<?php

declare(strict_types=1);

namespace App\Admin\Site\Page;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\RelatedToSite\ConfigureFieldArticleRelatedToSiteTrait;
use App\Entity\Page\PageRelatedArticle;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method PageRelatedArticle|null getSubject()
 */
class ArticleRelatedAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;
    use ConfigureFieldArticleRelatedToSiteTrait;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'name',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldArticleRelatedToSite(filter: $filter, options: [
            'label'       => 'PAGE_RELATED_ARTICLE_ENTITY.LABEL.ARTICLE',
            'help'        => 'PAGE_RELATED_ARTICLE_ENTITY.HELP.ARTICLE',
            'placeholder' => 'PAGE_RELATED_ARTICLE_ENTITY.PLACEHOLDER.ARTICLE',
        ]);

        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldPosition($list);

        $this->configureListFieldText($list, 'article.title', 'PAGE_RELATED_ARTICLE_ENTITY.LABEL.ARTICLE');

        $this->configureListFieldActive($list);
        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $this->configureFormFieldPosition($form);
        $this->configureFormFieldActive($form);

        $this->configureFormFieldArticleRelatedToSite(form: $form, options: [
            'label'       => 'PAGE_RELATED_ARTICLE_ENTITY.LABEL.ARTICLE',
            'help'        => 'PAGE_RELATED_ARTICLE_ENTITY.HELP.ARTICLE',
            'placeholder' => 'PAGE_RELATED_ARTICLE_ENTITY.PLACEHOLDER.ARTICLE',
            'btn_add'     => false,
            'required'    => true,
            'constraints' => [new NotBlank()],
        ]);
    }
}
