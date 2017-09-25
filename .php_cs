<?php

$finder = \PhpCsFixer\Finder::create()
    ->in([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
;

return \PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP56Migration' => true,
        '@PHP70Migration' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'combine_consecutive_unsets' => true,
        'declare_strict_types' => true,
        'doctrine_annotation_braces' => true,
        'doctrine_annotation_indentation' => true,
        'doctrine_annotation_spaces' => true,
        'general_phpdoc_annotation_remove' => [
            'covers',
        ],
        'linebreak_after_opening_tag' => true,
        'modernize_types_casting' => true,
        'native_function_invocation' => true,
        'no_php4_constructor' => true,
        'no_unreachable_default_argument_value' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
        'phpdoc_summary' => false,
        'semicolon_after_instruction' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
