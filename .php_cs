<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
  ->exclude(['vendor', 'cache', 'bin'])
  ->in(__DIR__);

return Config::create()
  ->setIndent('  ')
  ->setRules([
    '@PSR2'                       => true,
    'no_unused_imports'           => true,
    'native_function_invocation'  => [
      'include' => ['@internal'],
    ],
    'binary_operator_spaces'      => [
      'align_double_arrow'  => true,
      'align_equals'        => true,
    ]
  ])
  ->setFinder($finder);
