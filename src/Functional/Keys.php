<?php

/**
 * keys
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const keys = __NAMESPACE__ . '\\keys';

/**
 * keys
 * returns an array whose constituents are the keys in a specified list
 *
 * keys :: [a] -> [b]
 *
 * @param array|object $list
 * @return array
 */
function keys($list): array
{
  return fold(
    function (array $keys, $_, $idx) {
      $keys[] = $idx;

      return unique($keys);
    },
    $list,
    []
  );
}
