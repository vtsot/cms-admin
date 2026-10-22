<?php

declare(strict_types=1);

namespace App\Admin\User\Traits;

use App\Entity\User;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;

use function array_filter;
use function implode;

trait ConfigureFilterAutocompleteUserTrait
{
    protected function configureFilterFieldAutocompleteUsers(
        DatagridMapper $filter,
        ?string $name = null,
        ?string $label = null,
        ?array $options = [],
    ): void {
        $name  ??= 'user';
        $label ??= 'USER_ENTITY.LABEL.USER';

        $filter->add(
            $name,
            ModelFilter::class,
            [
                'label'         => $label,
                'field_type'    => ModelAutocompleteType::class,
                'field_options' => [
                    'property'           => $options['property'] ?? ['email', 'firstName', 'lastName'],
                    'to_string_callback' => static function (/** @var User $entity */ $entity) {
                        $labels   = [];
                        $labels[] = (string) $entity;

                        return implode(' ', array_filter($labels));
                    },
                ],
            ],
            [
                'admin_code' => 'admin.user.all',
            ]
        );
    }
}
