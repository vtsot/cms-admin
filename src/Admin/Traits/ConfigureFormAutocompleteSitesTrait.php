<?php

declare(strict_types=1);

namespace App\Admin\Traits;

use App\Entity\Site\Site;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

use function array_filter;
use function implode;
use function preg_replace;

trait ConfigureFormAutocompleteSitesTrait
{
    protected function configureFormFieldAutocompleteSites(
        FormMapper $form,
        ?string $name = null,
        ?string $label = null,
        ?array $options = [],
    ): void {
        $name  ??= 'sites';
        $label ??= 'SITE_ENTITY.LABEL.SITES';

        $form
            ->add(
                $name,
                ModelAutocompleteType::class,
                [
                    'property'             => $options['property'] ?? ['title', 'domain'],
                    'attr'                 => ['data-sonata-select2-allow-clear' => 'true'],
                    'label'                => $label,
                    'required'             => $options['required'] ?? false,
                    'btn_add'              => $options['btn_add'] ?? false,
                    'empty_data'           => $options['empty_data'] ?? [],
                    'multiple'             => $options['multiple'] ?? true,
                    'minimum_input_length' => $options['minimum_input_length'] ?? 3,
                    'to_string_callback'   => static function (/** @var Site $entity */ $entity) {
                        $labels   = [];
                        $labels[] = $entity->getTitle();

                        if ($entity->getDomain()) {
                            $labels[] = '(' . preg_replace('#^http(s)?://#', '', $entity->getDomain()) . ')';
                        }

                        return implode(' ', array_filter($labels));
                    },
                ],
                [
                    'admin_code' => 'admin.site',
                ]
            );
    }
}
