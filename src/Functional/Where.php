<?php

/**
 * where function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const where = __NAMESPACE__ . '\\where';

/**
 * where
 * searches a multi-dimensional array using a fragment of a sub-array defined in the said composite
 *
 * where :: [[a], [b]] -> [a] -> [[a]]
 *
 * @param array|object $list
 * @param array|object $search
 * @return array
 * @example
 *
 * where([
 *  ['pos' => 'pg', 'name' => 'magic'],
 *  ['pos' => 'sg', 'name' => 'jordan']
 * ], ['name' => 'jordan'])
 * => [['pos' => 'sg', 'name' => 'jordan']]
 */
function where($list, $search): array
{
  return fold(
    function (
      array $acc,
      $value,
      $key
    ) use ($search): array {
      if (!(\is_object($search) || \is_array($search))) {
        return $acc;
      }

      foreach ($search as $idx => $nxt) {
        if (\is_array($value) || \is_object($value)) {
          foreach ($value as $ikey => $ival) {
            if (equals($ikey, $idx) && equals($ival, $nxt, true)) {
              $acc[] = $value;
            }

            if (\is_array($ival) || \is_object($ival)) {
              $acc = extend(
                $acc,
                where($value, $search)
              );
            }
          }
        } else {
          if (equals($key, $idx) && equals($value, $nxt, true)) {
            $acc[][$key] = $value;
          }
        }
      }

      return $acc;
    },
    $list,
    []
  );
}
