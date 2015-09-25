<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
    ->fixers(array(
        '-phpdoc_params',
        '-align_double_arrow',
        '-align_equals',
        '-concat_without_spaces',
        'logical_not_operators_with_spaces',
        'short_array_syntax_fixer',
    ))
    ->finder($finder);
