<?php

declare(strict_types=1);

namespace App\Admin\Traits;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use function array_merge;

trait ConfigureListTrait
{
    protected function configureListFieldDate(
        ListMapper $list,
        string $name,
        ?string $label = null,
        array $options = [],
    ): void {
        $list->add(
            $name,
            FieldDescriptionInterface::TYPE_DATETIME,
            array_merge(
                [
                    'label'        => $label,
                    'header_style' => 'width:130px;',
                ],
                $options
            )
        );
    }

    protected function configureListFieldCreatedAt(ListMapper $list): void
    {
        $this->configureListFieldDate($list, 'createdAt', 'FIELD.CREATED_AT');
    }

    protected function configureListFieldUpdatedAt(ListMapper $list): void
    {
        $this->configureListFieldDate($list, 'updatedAt', 'FIELD.UPDATED_AT');
    }

    protected function configureListFieldActive(
        ListMapper $list,
        ?string $name = null,
        ?string $label = null,
        array $options = [],
    ): void {
        $name  ??= 'active';
        $label ??= 'FIELD.ACTIVE';
        $list->add(
            $name,
            FieldDescriptionInterface::TYPE_BOOLEAN,
            array_merge(
                [
                    'label'        => $label,
                    'header_style' => 'width:100px;',
                    'editable'     => true,
                ],
                $options
            )
        );
    }

    protected function configureListFieldText(
        ListMapper $list,
        string $name,
        ?string $label = null,
        array $options = [],
    ): void {
        $list->add(
            $name,
            TextType::class,
            array_merge(
                [
                    'label' => $label,
                ],
                $options
            )
        );
    }

    protected function configureListFieldArray(
        ListMapper $list,
        string $name,
        ?string $label = null,
        array $options = [],
    ): void {
        $list->add(
            $name,
            FieldDescriptionInterface::TYPE_ARRAY,
            array_merge(
                [
                    'label' => $label,
                ],
                $options
            )
        );
    }

    protected function configureListFieldEnum(
        ListMapper $list,
        string $name,
        ?string $label = null,
        array $options = [],
    ): void {
        $list->add(
            $name,
            FieldDescriptionInterface::TYPE_ENUM,
            array_merge(
                [
                    'label' => $label,
                ],
                $options
            )
        );
    }

    protected function configureListFieldHtml(
        ListMapper $list,
        string $name,
        ?string $label = null,
        array $options = [],
    ): void {
        $list->add(
            $name,
            'html',
            array_merge(
                [
                    'label'    => $label,
                    'truncate' => ['length' => 300, 'preserve' => true],
                ],
                $options
            )
        );
    }

    protected function configureListFieldPosition(
        ListMapper $list,
        ?string $name = null,
        ?string $label = null,
        array $options = [],
    ): void {
        $name  ??= 'position';
        $label ??= 'FIELD.POSITION';
        $list->add(
            $name,
            FieldDescriptionInterface::TYPE_INTEGER,
            array_merge(
                [
                    'label'        => $label,
                    'header_style' => 'width:100px;',
                    'editable'     => true,
                ],
                $options
            )
        );
    }

    protected function configureListFieldLinkEntity(
        ListMapper $list,
        string $name,
        ?string $label = null,
        array $options = [],
        ?string $template = null,
    ): void {
        $template ??= 'admin/CRUD/list__link_entity_url.html.twig';
        $list
            ->add(
                $name,
                'url',
                array_merge(
                    [
                        'label'      => $label ?? 'FIELD.LINK_ENTITY.LINK_URL',
                        'sortable'   => false,
                        'attributes' => ['target' => '_blank'],
                        'template'   => $template,
                    ],
                    $options
                )
            );
    }

    protected function configureListFieldActions(
        ListMapper $list,
        array $actions = [],
        array $options = [],
        ?string $width = '180px',
    ): void {
        $actions = $actions ?: ['edit' => [], 'delete' => []];
        $list->add(
            ListMapper::NAME_ACTIONS,
            ListMapper::TYPE_ACTIONS,
            array_merge(
                [
                    'row_align'    => 'center',
                    'actions'      => $actions,
                    'label'        => 'ADMIN.LABEL.ACTIONS',
                    'header_style' => $width ? 'width:' . $width . ';' : null,
                ],
                $options,
            )
        );
    }

    protected function configureListFieldChildrenActions(
        ListMapper $list,
        array $actions = [],
        array $options = [],
        ?string $width = '100px',
        ?string $template = 'admin/CRUD/list__action_children.html.twig',
    ): void {
        $actions = $actions ?: [
            'children' => ['template' => $template],
            'edit'     => [],
            'delete'   => [],
        ];

        $this->configureListFieldActions($list, $actions, $options, $width);
    }

    protected function configureListFieldNumber(
        ListMapper $list,
        string $name,
        ?string $label = null,
        array $options = [],
    ): void {
        $options['label'] = $label;

        $list->add($name, FieldDescriptionInterface::TYPE_INTEGER, $options);
    }

    protected function configureListFieldBoolean(
        ListMapper $list,
        string $name,
        ?string $label = null,
        array $options = [],
    ): void {
        $options['label'] = $label;

        $list->add($name, FieldDescriptionInterface::TYPE_BOOLEAN, $options);
    }

    protected function configureListFieldManyToMany(
        ListMapper $list,
        string $name,
        string $property,
        ?string $label = null,
        array $options = [],
    ): void {
        $options['label']                         = $label;
        $options['field_options']['choice_label'] = $property;

        $list->add($name, FieldDescriptionInterface::TYPE_MANY_TO_MANY, $options);
    }

    protected function configureListFieldChangedAt(
        ListMapper $list,
        ?string $name = 'changedAt',
        ?array $options = [],
        ?string $width = '220px',
        ?string $template = null,
    ): void {
        $template ??= 'admin/CRUD/list__changed_at.html.twig';
        $list->add(
            $name,
            null,
            array_merge(
                [
                    'virtual_field' => true,
                    'sortable'      => false,
                    'row_align'     => 'left',
                    'label'         => 'FIELD.CHANGED_AT',
                    'header_style'  => $width ? 'width:' . $width . ';' : null,
                    'template'      => $template,
                ],
                $options,
            )
        );
    }

    protected function configureListFieldChangedBy(
        ListMapper $list,
        ?string $name = 'createdBy',
        ?array $options = [],
        ?string $width = '270px',
        ?string $template = null,
    ): void {
        $template ??= 'admin/CRUD/list__changed_by.html.twig';
        $list->add(
            $name,
            null,
            array_merge(
                [
                    'virtual_field' => true,
                    'sortable'      => false,
                    'row_align'     => 'left',
                    'label'         => 'FIELD.CHANGED_BY',
                    'header_style'  => $width ? 'width:' . $width . ';' : null,
                    'template'      => $template,
                ],
                $options,
            )
        );
    }

    protected function configureListFieldExternalId(
        ListMapper $list,
        ?string $name = 'externalId',
        ?array $options = [],
        ?string $width = '100px',
        ?string $template = null,
    ): void {
        $template ??= 'admin/CRUD/list_external_id_synchronized.html.twig';
        $list->add(
            $name,
            null,
            array_merge(
                [
                    'sortable'     => false,
                    'row_align'    => 'left',
                    'label'        => 'EXTERNAL_ID.SYNCHRONIZED',
                    'header_style' => $width ? 'width:' . $width . ';' : null,
                    'template'     => $template,
                ],
                $options,
            )
        );
    }

    protected function configureListFieldUrl(
        ListMapper $list,
        string $name,
        ?string $label = null,
        array $options = [],
    ): void {
        $options['label'] = $label;

        $options['attributes']['target'] = '_blank';

        $list->add($name, FieldDescriptionInterface::TYPE_URL, $options);
    }
}
