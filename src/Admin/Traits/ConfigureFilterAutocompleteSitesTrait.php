<?php

declare(strict_types=1);

namespace App\Admin\Traits;

use App\Entity\Site\Site;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;

use function array_filter;
use function implode;

trait ConfigureFilterAutocompleteSitesTrait
{
    protected function configureFilterFieldAutocompleteSites(
        DatagridMapper $filter,
        ?string $name = null,
        ?string $label = null,
        ?array $options = [],
        ?string $adminCode = 'admin.site',
    ): void {
        $name  ??= 'sites';
        $label ??= 'SITE_ENTITY.LABEL.SITES';

        $filter->add(
            $name,
            ModelFilter::class,
            [
                'label'         => $label,
                'field_type'    => ModelAutocompleteType::class,
                'field_options' => [
                    'property'           => $options['property'] ?? ['domain', 'title'],
                    'to_string_callback' => static function (/** @var Site $entity */ $entity) {
                        $labels   = [];
                        $labels[] = $entity->getTitle();
                        $labels[] = $entity->getDomain();

                        return implode(' ', array_filter($labels));
                    },
                ],
            ],
            [
                'admin_code' => $adminCode,
            ]
        );
    }
}
