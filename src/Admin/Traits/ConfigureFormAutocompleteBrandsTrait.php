<?php

declare(strict_types=1);

namespace App\Admin\Traits;

use App\Entity\Brand;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

use function array_filter;
use function implode;

trait ConfigureFormAutocompleteBrandsTrait
{
    protected function configureFormFieldAutocompleteBrands(
        FormMapper $form,
        ?string $name = null,
        ?string $label = null,
        ?string $help = null,
        ?array $options = [],
    ): void {
        $name  ??= 'brands';
        $label ??= 'BRAND_ENTITY.LABEL.NAMES';
        $help  ??= 'BRAND_ENTITY.HELP.NAMES';

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
                    'to_string_callback'   => static function (/** @var Brand $entity */ $entity) {
                        $labels   = [];
                        $labels[] = $entity->getName();

                        return implode(' ', array_filter($labels));
                    },
                ],
                [
                    'admin_code' => 'admin.brand',
                ]
            );
    }
}
