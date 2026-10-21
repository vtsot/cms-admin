<?php

declare(strict_types=1);

namespace App\Admin\Faq;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Faq\Faq;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method Faq|null getSubject()
 */
class FaqAdmin extends AbstractAdmin
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
        $filter
            ->add('title', null, ['label' => 'FAQ_ENTITY.LABEL.TITLE'])
            ->add('content', null, ['label' => 'FAQ_ENTITY.LABEL.CONTENT']);
        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldPosition($list);
        $this->configureListFieldText($list, 'title', 'FAQ_ENTITY.LABEL.TITLE');
        $this->configureListFieldHtml($list, 'content', 'FAQ_ENTITY.LABEL.CONTENT');
        $this->configureListFieldActive($list);
        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with($this->trans('FAQ_ENTITY.SECTION.MAIN'));

        $form->add(
            'title',
            TextType::class,
            [
                'required'    => true,
                'label'       => 'FAQ_ENTITY.LABEL.TITLE',
                'help'        => 'FAQ_ENTITY.HELP.TITLE',
                'constraints' => [
                    new NotBlank(),
                ],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'content',
            CKEditorType::class,
            [
                'required'    => false,
                'label'       => 'FAQ_ENTITY.LABEL.CONTENT',
                'help'        => 'FAQ_ENTITY.HELP.CONTENT',
                'config_name' => self::CK_EDITOR_FAQ_CONFIG,
                'trim'        => true,
                'config'      => [],
            ],
        );

        $form->end();
    }
}
