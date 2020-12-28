<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
  ->exclude(['vendor', 'cache', 'bin'])
  ->in(__DIR__);

return Config::create()
  ->setRules([
    'linebreak_after_opening_tag'       => true,
    'no_trailing_comma_in_list_call'    => false,
    'trailing_comma_in_multiline_array' => true,
    'blank_line_before_return'          => true,
    'date_time_immutable'               => true,
    'no_trailing_comma_in_list_call'    => false,
    'no_trailing_whitespace'            => true,
    'no_unused_imports'                 => true,
    'native_function_invocation'        => [
      'include' => ['@internal'],
    ],
    'braces'                            => [
      'allow_single_line_closure'                   => false,
      'position_after_anonymous_constructs'         => 'same',
      'position_after_control_structures'           => 'same',
      'position_after_functions_and_oop_constructs' => 'next',
    ],
    'class_definition'                  => [
      'multiLineExtendsEachSingleLine'  => false,
      'singleItemSingleLine'            => false,
      'singleLine'                      => false,
    ],
    'binary_operator_spaces'            => [
      'align_double_arrow'  => true,
      'align_equals'        => true,
    ],
  ])
  ->setFinder($finder)
  ->setIndent('  ');
