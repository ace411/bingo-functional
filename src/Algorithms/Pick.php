<?php

/**
 * Pick function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const pick = __NAMESPACE__ . '\\pick';

/**
 * pick
 * picks an item from a list
 *
 * pick :: [a] -> a -> b -> a
 * 
 * @param array|object $values
 * @param mixed $search
 * @param mixed $default
 * @return mixed
 * 
 * pick(['foo', 'bar', 'baz'], 2, '')
 * //=> ''
 */
function pick($values, $search, $default = null)
{
  return _fold(function ($acc, $val) use ($search) {
    if ($search == $val) {
      $acc = $val;
    }

    return $acc;
  }, $values, $default);
}
