<?php

declare(strict_types=1);

namespace App\Admin\Traits;

use App\Entity\GenericName;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;

use function array_filter;
use function implode;

trait ConfigureFilterAutocompleteGenericNamesTrait
{
    protected function configureFilterFieldAutocompleteGenericNames(
        DatagridMapper $filter,
        ?string $name = null,
        ?string $label = null,
        ?array $options = [],
    ): void {
        $name  ??= 'genericNames';
        $label ??= 'GENERIC_NAME_ENTITY.LABEL.NAME';

        $filter->add(
            $name,
            ModelFilter::class,
            [
                'label'         => $label,
                'field_type'    => ModelAutocompleteType::class,
                'field_options' => [
                    'property'           => $options['property'] ?? ['name'],
                    'to_string_callback' => static function (/** @var GenericName $entity */ $entity) {
                        $labels   = [];
                        $labels[] = $entity->getName();

                        return implode(' ', array_filter($labels));
                    },
                ],
            ],
            [
                'admin_code' => 'admin.generic_name',
            ]
        );
    }
}
