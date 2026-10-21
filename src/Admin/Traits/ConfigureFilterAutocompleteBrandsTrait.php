<?php

declare(strict_types=1);

namespace App\Admin\Traits;

use App\Entity\Brand;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;

use function array_filter;
use function implode;

trait ConfigureFilterAutocompleteBrandsTrait
{
    protected function configureFilterFieldAutocompleteBrands(
        DatagridMapper $filter,
        ?string $name = null,
        ?string $label = null,
        ?array $options = [],
    ): void {
        $name  ??= 'brands';
        $label ??= 'BRAND_ENTITY.LABEL.NAME';

        $filter->add(
            $name,
            ModelFilter::class,
            [
                'label'         => $label,
                'field_type'    => ModelAutocompleteType::class,
                'field_options' => [
                    'property'           => $options['property'] ?? ['name'],
                    'to_string_callback' => static function (/** @var Brand $entity */ $entity) {
                        $labels   = [];
                        $labels[] = $entity->getName();

                        return implode(' ', array_filter($labels));
                    },
                ],
            ],
            [
                'admin_code' => 'admin.brand',
            ]
        );
    }
}
