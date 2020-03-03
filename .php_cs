<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
  ->exclude(['vendor', 'cache', 'bin'])
  ->in(__DIR__);

return Config::create()
  ->setRules([
    '@PSR2'                   => true,
    'binary_operator_spaces'  => [
      'align_double_arrow'  => true,
      'align_equals'        => true,
    ]
  ])
  ->setFinder($finder);
