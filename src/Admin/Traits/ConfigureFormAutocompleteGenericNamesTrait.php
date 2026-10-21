<?php

declare(strict_types=1);

namespace App\Admin\Traits;

use App\Entity\GenericName;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

use function array_filter;
use function implode;

trait ConfigureFormAutocompleteGenericNamesTrait
{
    protected function configureFormFieldAutocompleteGenericNames(
        FormMapper $form,
        ?string $name = null,
        ?string $label = null,
        ?string $help = null,
        ?array $options = [],
    ): void {
        $name  ??= 'genericNames';
        $label ??= 'GENERIC_NAME_ENTITY.LABEL.NAMES';
        $help  ??= 'GENERIC_NAME_ENTITY.HELP.NAMES';

        $form
            ->add(
                $name,
                ModelAutocompleteType::class,
                [
                    'property'             => $options['property'] ?? ['name'],
                    'attr'                 => ['data-sonata-select2-allow-clear' => 'true'],
                    'label'                => $label,
                    'help'                 => $help,
                    'required'             => $options['required'] ?? false,
                    'btn_add'              => $options['btn_add'] ?? false,
                    'empty_data'           => $options['empty_data'] ?? [],
                    'multiple'             => $options['multiple'] ?? true,
                    'minimum_input_length' => $options['minimum_input_length'] ?? 3,
                    'to_string_callback'   => static function (/** @var GenericName $entity */ $entity) {
                        $labels   = [];
                        $labels[] = $entity->getName();

                        return implode(' ', array_filter($labels));
                    },
                ],
                [
                    'admin_code' => 'admin.generic_name',
                ]
            );
    }
}
