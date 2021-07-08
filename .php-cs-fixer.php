<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
  ->exclude(['vendor', 'cache', 'bin'])
  ->in(__DIR__);

$config = new Config;

return $config
  ->setRules([
    'linebreak_after_opening_tag'    => true,
    'no_trailing_comma_in_list_call' => false,
    'trailing_comma_in_multiline'    => true,
    'blank_line_before_statement'    => true,
    'date_time_immutable'            => true,
    'no_trailing_comma_in_list_call' => false,
    'no_trailing_whitespace'         => true,
    'no_unused_imports'              => true,
    'braces'                         => [
      'allow_single_line_closure'                   => false,
      'position_after_anonymous_constructs'         => 'same',
      'position_after_control_structures'           => 'same',
      'position_after_functions_and_oop_constructs' => 'next',
    ],
    'class_definition'               => [
      'multi_line_extends_each_single_line'  => false,
      'single_item_single_line'              => false,
      'single_line'                          => false,
    ],
    'binary_operator_spaces'         => [
      'operators' => ['=>' => 'align', '=' => 'align'],
    ],
  ])
  ->setFinder($finder)
  ->setIndent('  ');
