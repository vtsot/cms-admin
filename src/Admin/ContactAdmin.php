<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Contact;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @method Contact|null getSubject()
 */
class ContactAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection->add('show');
        $collection->clearExcept(['list', 'show']);
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'DESC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'name', 'CONTACT_ENTITY.LABEL.NAME');
        $this->configureFilterFieldText($filter, 'email', 'CONTACT_ENTITY.LABEL.EMAIL');
        $this->configureFilterFieldText($filter, 'message', 'CONTACT_ENTITY.LABEL.MESSAGE');

        $this->configureFilterFieldCreatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText($list, 'name', 'CONTACT_ENTITY.LABEL.NAME');
        $this->configureListFieldText($list, 'email', 'CONTACT_ENTITY.LABEL.EMAIL');
        $this->configureListFieldHtml($list, 'message', 'CONTACT_ENTITY.LABEL.MESSAGE', [
            'header_style' => 'width:400px;',
        ]);

        $this->configureListFieldCreatedAt($list);
        $this->configureListFieldActions(list: $list, actions: ['show' => []]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('CONTACT_ENTITY.SECTION.MAIN');

        $form->add(
            'name',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'CONTACT_ENTITY.LABEL.NAME',
                'help'               => 'CONTACT_ENTITY.HELP.NAME',
                'constraints'        => [],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'email',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'CONTACT_ENTITY.LABEL.EMAIL',
                'help'               => 'CONTACT_ENTITY.HELP.EMAIL',
                'constraints'        => [],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->add(
            'message',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'CONTACT_ENTITY.LABEL.MESSAGE',
                'help'               => 'CONTACT_ENTITY.HELP.MESSAGE',
                'constraints'        => [],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->end();
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id', null, ['label' => 'CONTACT_ENTITY.LABEL.ID'])
            ->add('name', null, ['label' => 'CONTACT_ENTITY.LABEL.NAME'])
            ->add('email', FieldDescriptionInterface::TYPE_EMAIL, ['label' => 'CONTACT_ENTITY.LABEL.EMAIL'])
            ->add('message', null, ['label' => 'CONTACT_ENTITY.LABEL.EMAIL'])
            ->add('createdAt', null, ['label' => 'FIELD.CREATED_AT'])
            ->add('updatedAt', null, ['label' => 'FIELD.UPDATED_AT']);
    }
}
