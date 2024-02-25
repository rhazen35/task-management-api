<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        'declare_strict_types' => true,
        'ordered_class_elements' => false,
        'visibility_required' => [
            'elements'=> [
                'property',
                'method'
            ],
        ],
        'global_namespace_import' => [
            'import_classes' => null,
        ],
        'phpdoc_separation' => false,
        'trailing_comma_in_multiline' => [
            'elements' => [
                'arrays',
                'arguments',
                'parameters',
            ],
        ],
    ])
    ->setFinder($finder);
