<?php

declare(strict_types=1);

namespace App\Admin\Review;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Review\AbstractReviewQuestionItem;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method AbstractReviewQuestionItem|null getSubject()
 */
class AbstractReviewQuestionItemAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'position',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'title', 'REVIEW_QUESTION_ITEM_ENTITY.LABEL.TITLE');
        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldPosition($list);
        $this->configureListFieldText(
            $list,
            'title',
            'REVIEW_QUESTION_ITEM_ENTITY.LABEL.TITLE',
            ['identifier' => true, 'route' => ['name' => 'edit']],
        );

        $this->configureListFieldActive($list);
        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('REVIEW_QUESTION_ITEM_ENTITY.SECTION.MAIN');
        $form->add(
            'title',
            TextType::class,
            [
                'required'    => true,
                'label'       => 'REVIEW_QUESTION_ITEM_ENTITY.LABEL.TITLE',
                'help'        => 'REVIEW_QUESTION_ITEM_ENTITY.HELP.TITLE',
                'constraints' => [new NotBlank()],
            ],
        );
    }
}
