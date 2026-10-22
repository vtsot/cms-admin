<?php

declare(strict_types=1);

namespace App\Admin\User\Traits;

use App\Entity\User;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

use function array_filter;
use function implode;

trait ConfigureFormAutocompleteUserTrait
{
    protected function configureFormFieldAutocompleteUser(
        FormMapper $form,
        ?string $name = null,
        ?string $label = null,
        ?array $options = [],
    ): void {
        $name  ??= 'user';
        $label ??= 'USER_ENTITY.LABEL.USER';

        $form
            ->add(
                $name,
                ModelAutocompleteType::class,
                [
                    'property'             => $options['property'] ?? ['email', 'firstName', 'lastName'],
                    'attr'                 => ['data-sonata-select2-allow-clear' => 'true'],
                    'label'                => $label,
                    'required'             => $options['required'] ?? false,
                    'btn_add'              => $options['btn_add'] ?? false,
                    'empty_data'           => $options['empty_data'] ?? [],
                    'multiple'             => $options['multiple'] ?? false,
                    'minimum_input_length' => $options['minimum_input_length'] ?? 3,
                    'to_string_callback'   => static function (/** @var User $entity */ $entity) {
                        $labels   = [];
                        $labels[] = (string) $entity;

                        return implode(' ', array_filter($labels));
                    },
                ],
                [
                    'admin_code' => 'admin.user.all',
                ]
            );
    }
}
