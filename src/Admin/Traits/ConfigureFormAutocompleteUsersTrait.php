<?php

declare(strict_types=1);

namespace App\Admin\Traits;

use App\Entity\User;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

use function array_filter;
use function implode;

trait ConfigureFormAutocompleteUsersTrait
{
    protected function configureFormFieldAutocompleteUsers(
        FormMapper $form,
        ?string $name = null,
        ?string $label = null,
        ?string $help = null,
        ?array $options = [],
        ?string $adminCode = 'admin.user.all',
    ): void {
        $name  ??= 'users';
        $label ??= 'USER_ENTITY.LABEL.USERS';

        $form
            ->add(
                $name,
                ModelAutocompleteType::class,
                [
                    'property'             => $options['property'] ?? ['email', 'firstName', 'lastName'],
                    'attr'                 => ['data-sonata-select2-allow-clear' => 'true'],
                    'label'                => $label,
                    'help'                 => $help ?? '',
                    'required'             => $options['required'] ?? false,
                    'btn_add'              => $options['btn_add'] ?? false,
                    'empty_data'           => $options['empty_data'] ?? [],
                    'multiple'             => $options['multiple'] ?? true,
                    'minimum_input_length' => $options['minimum_input_length'] ?? 3,
                    'to_string_callback'   => static function (/** @var User $entity */ $entity) {
                        $labels   = [];
                        $labels[] = $entity->getFullName();
                        $labels[] = ' (' . $entity->getEmail() . ')';

                        return implode(' ', array_filter($labels));
                    },
                ],
                [
                    'admin_code' => $adminCode,
                ]
            );
    }
}
