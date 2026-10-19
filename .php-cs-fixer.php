<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(
        [
            __DIR__ . '/src',
            __DIR__ . '/tests/Suite/Acceptance',
            __DIR__ . '/tests/Suite/Api',
            __DIR__ . '/tests/Suite/Unit',
            __DIR__ . '/tests/Suite/Web',
            //__DIR__ . '/tests/Factory',
            __DIR__ . '/tests/Support/Helper',
        ]
    );

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony'                                         => true,
        '@PHP83Migration'                                  => true,
        'binary_operator_spaces'                           => ['operators' => ['=>' => 'align_single_space_minimal', '=' => 'align_single_space_minimal', '??=' => 'align_single_space_minimal', '!=' => null]],
        'concat_space'                                     => ['spacing' => 'one'],
        'array_syntax'                                     => ['syntax' => 'short'],
        'ordered_imports'                                  => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'alpha'],
        'blank_line_after_namespace'                       => true,
        'blank_line_between_import_groups'                 => true,
        'linebreak_after_opening_tag'                      => true,
        'no_trailing_whitespace'                           => true,
        'no_unused_imports'                                => true,
        'no_useless_else'                                  => true,
        'no_useless_return'                                => true,
        'single_blank_line_at_eof'                         => true,
        'blank_lines_before_namespace'                     => ['min_line_breaks' => 2, 'max_line_breaks' => 2],
        'strict_comparison'                                => true,
        'strict_param'                                     => true,
        'declare_strict_types'                             => true,
        'compact_nullable_type_declaration'                => true,
        'no_superfluous_phpdoc_tags'                       => ['allow_mixed' => true, 'allow_unused_params' => true, 'remove_inheritdoc' => true],
        'increment_style'                                  => ['style' => 'post'],
        'phpdoc_to_comment'                                => false,
        'yoda_style'                                       => ['equal' => false, 'identical' => false, 'less_and_greater' => false, 'always_move_variable' => false],
        'single_line_throw'                                => false,
        'blank_line_before_statement'                      => ['statements' => ['break', 'continue', 'do', 'exit', 'for', 'foreach', 'goto', 'if', 'return', 'switch', 'throw', 'try', 'while', 'yield', 'yield_from']],
        'trailing_comma_in_multiline'                      => ['after_heredoc' => false, 'elements' => ['arrays', 'parameters', 'match']],
        'no_trailing_comma_in_singleline'                  => true,
        'method_argument_space'                            => ['on_multiline' => 'ignore', 'keep_multiple_spaces_after_comma' => false],
        'global_namespace_import'                          => ['import_classes' => true, 'import_constants' => true, 'import_functions' => true],
        'nullable_type_declaration_for_default_null_value' => true,
        'date_time_immutable'                              => true,
        'native_function_invocation'                       => ['scope' => 'namespaced'],
        'native_constant_invocation'                       => ['scope' => 'namespaced'],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
