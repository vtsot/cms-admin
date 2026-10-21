<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

class ExampleAdvancedCmsEmbed extends AbstractCmsEmbed
{
    public const ID     = 'example-advanced';
    public const LABEL  = 'Example Advanced CmsEmbed';
    public const HELP   = '';
    public const ACTIVE = false;

    /**
     * @see https://ckeditor.com/docs/ckeditor4/latest/guide/dev_howtos_dialog_windows.html
     * @see https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_dialog_definition.html
     */
    public const PARAMS = [
        [
            'id'           => 'example-advanced-param-1',
            'type'         => 'select',
            'label'        => 'example-advanced-param-1-name',
            'default'      => null,
            'replace_help' => true, // custom parameter: show value as help
            'items'        => [
                // label => id
                ['option text 1', 'value1'],
                ['option text 2', 'value2'],
                ['option text 3', 'value3'],
            ],
        ],
        [
            'id'           => 'custom-text',
            'type'         => 'text',
            'label'        => 'Custom Text Field',
            'default'      => 'Default custom text field value',
            'replace_help' => true, // custom parameter: show value as help
        ],
        [
            'id'           => 'custom-textarea',
            'type'         => 'textarea',
            'label'        => 'Custom Textarea Field',
            'default'      => 'Default custom textarea field value',
            'replace_help' => true, // custom parameter: show value as help
        ],
        [
            'id'           => 'custom-checkbox-1',
            'type'         => 'checkbox',
            'label'        => 'This checkbox is checked by default',
            'default'      => true,
            'replace_help' => true, // custom parameter: show value as help
        ],
        [
            'id'           => 'custom-checkbox-2',
            'type'         => 'checkbox',
            'label'        => 'This checkbox is not checked by default',
            'default'      => false,
            'replace_help' => true, // custom parameter: show value as help
        ],
        [
            'id'           => 'custom-checkbox-3',
            'type'         => 'checkbox',
            'label'        => 'Checkbox Label',
            'default'      => false,
            'replace_help' => true, // custom parameter: show value as help
        ],
        [
            'id'           => 'custom-radio-1',
            'type'         => 'radio',
            'label'        => 'Radio',
            'default'      => 'radio-2',
            'buttonLayout' => 'vertical',
            'replace_help' => true, // custom parameter: show value as help
            'items'        => [
                // label => id
                ['Radio #1', 'radio-1'],
                ['Radio #2', 'radio-2'],
                ['Radio #3', 'radio-3'],
                ['Radio #4', 'radio-4'],
            ],
        ],
        // define the main mask element
        [
            'id'           => 'select-mask-1',
            'type'         => 'select',
            'label'        => 'Select Mask #1',
            'default'      => null,
            'replace_help' => true, // custom parameter: show value as help
            'items'        => [
                // label => id
                ['Show Mask #1', 'mask-1'],
                ['Show Mask #2', 'mask-2'],
                ['Show Mask #3', 'mask-3'],
                ['Show Mask #4', 'mask-4'],
            ],
            // mask activator,
            // main mask element, required to mark as mask functionality
            'mask' => true,
            // className must be equal to the current param id, see the id key
            'className' => 'select-mask-1',
            // map is the array of elements that will be shown or hide
            'map' => [
                // selected item value => array of
                'mask-1' => ['mask-checkbox-1'],
                'mask-2' => ['mask-checkbox-2', 'mask-checkbox-3'],
                'mask-3' => [],
                'mask-4' => ['mask-select-sub-1', 'mask-text-1'],
            ],
        ],

        // define the dependent masked elements
        // they defined as usual element
        [
            'id'        => 'mask-checkbox-1',
            'className' => 'mask-checkbox-1',
            'type'      => 'checkbox',
            'label'     => 'Masked checkbox #1',
            'default'   => false,
        ],
        [
            'id'           => 'mask-checkbox-2',
            'className'    => 'mask-checkbox-2',
            'type'         => 'checkbox',
            'label'        => 'Masked checkbox #2',
            'default'      => false,
            'replace_help' => true, // custom parameter: show value as help
        ],
        [
            'id'           => 'mask-checkbox-3',
            'className'    => 'mask-checkbox-3',
            'type'         => 'checkbox',
            'label'        => 'Masked checkbox #3',
            'default'      => false,
            'replace_help' => true, // custom parameter: show value as help
        ],
        [
            'id'        => 'mask-select-sub-1',
            'className' => 'mask-select-sub-1',
            'type'      => 'select',
            'label'     => 'Masked Select #1',
            'default'   => null,
            'items'     => [
                // label => id
                ['option1', 'value1'],
                ['option2', 'value2'],
                ['option3', 'value3'],
            ],
        ],
        [
            'id'        => 'mask-text-1',
            'className' => 'mask-text-1',
            'type'      => 'text',
            'label'     => 'Masked Text #1',
            'default'   => 'This inpit is displayed by mask conditions',
        ],
    ];
}
