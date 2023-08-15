<?php

/**
 * filterDeep function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

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
function filterDeep(callable $function, $list)
{
  return fold(
    function ($acc, $val, $idx) use ($function) {
      if (\is_object($acc)) {
        $acc->{$idx} = \is_array($val) || \is_object($val) ?
          filterDeep($function, $val) :
          head(filter($function, [$val]));

        if (\is_null($acc->{$idx})) {
          unset($acc->{$idx});
        }
      } elseif (\is_array($acc)) {
        $acc[$idx] = \is_array($val) || \is_object($val) ?
          filterDeep($function, $val) :
          head(filter($function, [$val]));

        if (\is_null($acc[$idx])) {
          unset($acc[$idx]);
        }
      }

      return $acc;
    },
    $list,
    $list
  );
}
