<?php

/**
 * filterDeep function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const filterDeep = __NAMESPACE__ . '\\filterDeep';

/**
 * filterDeep
 * selects list values that conform to a boolean predicate
 *
 * filterDeep :: (a -> Bool) -> [a] -> [a]
 *
 * @param callable $function
 * @param array $values
 * @return array
 * @example
 *
 * filterDeep(fn ($x) => strlen($x) === 3, [2, 'fa', 'foo'])
 * => ['foo']
 */
function filterDeep(callable $function, array $values): array
{
  return _fold(function ($acc, $val, $idx) use ($function) {
    $acc[$idx] = \is_array($val) ?
            filterDeep($function, $val) :
      head((filter)($function, [$val]));

    if ($acc[$idx] == null) {
      unset($acc[$idx]);
    }

    return $acc;
  }, $values, []);
}
