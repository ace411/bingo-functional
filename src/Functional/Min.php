<?php

/**
 * min function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const min = __NAMESPACE__ . '\\min';

/**
 * min
 * computes the lowest value in a collection
 *
 * min :: [a] -> Int
 *
 * @param array|object $list
 * @return int|float
 * @example
 *
 * min((object) [12, 4, 6, 99, 3])
 * => 3
 */
function min($list)
{
  // check if input is a number
  $numCheck = function ($number) {
    return \filter_var($number, FILTER_VALIDATE_INT | FILTER_VALIDATE_FLOAT);
  };
  // extract first element in list
  $fst = head($list);

  return fold(function ($acc, $val) use ($numCheck) {
    $comp = $numCheck($val);

    return $comp ? ($val < $acc ? $val : $acc) : $acc;
  }, $list, !$numCheck($fst) ? 0 : $fst);
}
