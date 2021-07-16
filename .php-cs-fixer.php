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
    '@PSR12'                      => true,
    'linebreak_after_opening_tag' => true,
    'binary_operator_spaces'      => [
      'operators' => ['=>' => 'align', '=' => 'align'],
    ],
  ])
  ->setFinder($finder)
  ->setIndent('  ');
