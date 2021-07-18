<?php

/**
 * Unique function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

use function Chemem\Bingo\Functional\Internal\_fold;

const unique = __NAMESPACE__ . '\\unique';

/**
 * unique
 * purges a list of duplicate values
 *
 * unique :: [a] -> [a]
 *
 * @param array $list
 * @return array
 * @example
 *
 * unique(['foo', 3, 'foo', 'baz'])
 * => ['foo', 3, 'baz']
 */
function unique(array $list): array
{
  return _fold(function ($acc, $val, $idx) {
    if (!\in_array($val, $acc)) {
      $acc[$idx] = $val;
    }

    return $acc;
  }, $list, []);
}
