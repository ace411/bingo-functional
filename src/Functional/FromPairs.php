<?php

/**
 * fromPairs function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const fromPairs = __NAMESPACE__ . '\\fromPairs';

/**
 * fromPairs
 * forms an associative array from discrete array pairs
 *
 * fromPairs :: [[a]] -> [a]
 *
 * @param array|object $list
 * @return array|object
 * @example
 *
 * fromPairs([['foo', 2], ['bar', 'bar']]);
 * => ['foo' => 2, 'bar' => 'bar']
 */
function fromPairs($list)
{
  return fold(
    function ($acc, $val, $key) {
      if (\is_array($val) || \is_object($val)) {
        $list = [];

        foreach ($val as $entry) {
          $list[] = $entry;

          if (equals(++$count, 2)) {
            $idx  = pluck($list, 0);
            $next = pluck($list, 1);

            if (\is_object($acc)) {
              $acc->{$idx} = $next;
              unset($acc->{$key});
            } elseif (\is_array($acc)) {
              $acc[$idx] = $next;
              unset($acc[$key]);
            }

            break;
          }
        }
      }

      return $acc;
    },
    $list,
    $list
  );
}
