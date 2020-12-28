<?php

/**
 * indexOf function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const indexOf = __NAMESPACE__ . '\\indexOf';

/**
 * indexOf
 * returns the index that corresponds to a specified list entry
 *
 * indexOf :: [a] -> a -> b -> b
 * 
 * @param array|object $list
 * @param mixed $value
 * @param mixed $default
 * @return mixed
 * 
 * indexOf(['x' => 'foo', 'y' => 3], 3)
 * //=> 'y'
 */
function indexOf($list, $value, $default = null)
{
  return _fold(function ($acc, $val, $idx) use ($value) {
    if ($val === $value) {
      $acc = $idx;
    }

    return $acc;
  }, $list, $default);
}
