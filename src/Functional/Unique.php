<?php

/**
 * Unique function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const unique = __NAMESPACE__ . '\\unique';

/**
 * unique
 * purges a list of duplicate values
 *
 * unique :: [a] -> [a]
 *
 * @param array|object $list
 * @return array|object
 * @example
 *
 * unique(['foo', 3, 'foo', 'baz'])
 * => ['foo', 3, 'baz']
 */
function unique($list)
{
  ['result' => $result] = fold(
    function (array $acc, $val, $idx) {
      if (!\in_array($val, $acc['count'])) {
        $acc['count'][$idx] = $val;
      } else {
        if (\is_object($acc['result'])) {
          unset($acc['result']->{$idx});
        } elseif (\is_array($acc['result'])) {
          unset($acc['result'][$idx]);
        }
      }

      return $acc;
    },
    $list,
    [
      'result'  => $list,
      'count'   => [],
    ]
  );

  return $result;
}
