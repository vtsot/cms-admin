<?php

declare(strict_types=1);

namespace App\Admin\Faq;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Faq\FaqGroup;
use App\Service\MessageBusHandler;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method FaqGroup|null getSubject()
 */
class FaqGroupAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    protected MessageBusHandler $messageBusHandler;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'title', 'FAQ_GROUP_ENTITY.LABEL.TITLE');
        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText($list, 'title', 'FAQ_GROUP_ENTITY.LABEL.TITLE');
        $this->configureListFieldActive($list);
        $this->configureListFieldChildrenActions(list: $list, width: '250px');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with($this->trans('FAQ_GROUP_ENTITY.SECTION.MAIN'));

        $form->add(
            'title',
            TextType::class,
            [
                'required'    => true,
                'label'       => 'FAQ_GROUP_ENTITY.LABEL.TITLE',
                'help'        => 'FAQ_GROUP_ENTITY.HELP.TITLE',
                'constraints' => [
                    new NotBlank(),
                ],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->end();
    }
}
