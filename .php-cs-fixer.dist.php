<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreVCSIgnored(true)
    ->exclude('.git/')
    ->exclude('.temp/')
    ->exclude('.tools/')
    ->exclude('.vscode/')
    ->exclude('clash/')
    ->exclude('codegolf/')
    ->exclude('contest/')
    ->notPath('optim/community/optim_com_cgfunge_prime.php')    // not a real php code
;
return (new PhpCsFixer\Config())
    // available rulesets and rules: https://github.com/FriendsOfPHP/PHP-CS-Fixer/tree/master/doc
    ->setRules([
        '@PSR12' => true,
        '@PHP81Migration' => true,
        '@PHP80Migration:risky' => true,    // this also needs: ->setRiskyAllowed(true)
        '@Symfony' => true,

        // override some @PHPxxMigration rules, because CG supports only php v7.3
        'assign_null_coalescing_to_coalesce_equal' => false, // override @PHP81Migration, ??= requires php v7.4
        'use_arrow_functions' => false,     // override @PHP80Migration:risky, => fn() requires php v7.4
        'modernize_strpos' => false,        // override @PHP80Migration:risky, str_contains() requires php v8.0

        // override some @Symfony rules
        'binary_operator_spaces' => ['operators' => ['=' => null, '=>' => null, 'and' => null, 'or' => null]],
        'blank_line_before_statement' => false,
        'class_attributes_separation' => false,
        'concat_space' => ['spacing' => 'one'],
        'increment_style'=> ['style' => 'post'],
        'phpdoc_to_comment' => false,
        'yoda_style' => false,
    ])
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__ . './.php-cs-fixer.cache')
    ->setIndent("    ")
    ->setLineEnding("\n")
    ->setFinder($finder)
;
