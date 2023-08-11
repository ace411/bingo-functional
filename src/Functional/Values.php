<?php

/**
 * values
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const values = __NAMESPACE__ . '\\values';

/**
 * values
 * returns an array whose constituents are the values in a specified list
 *
 * values :: [a] -> [a]
 *
 * @param array|object $list
 * @return array
 */
function values($list): array
{
  return fold(
    function (array $values, $entry) {
      $values[] = $entry;

      return unique($values);
    },
    $list,
    []
  );
}
