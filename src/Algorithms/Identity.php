<?php

/**
 * Identity function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const identity = __NAMESPACE__ . '\\identity';

/**
 * identity
 * returns the given value unchanged
 *
 * @param mixed $value
 * @return mixed
 *
 * identity(3)
 * //=> 3
 */
function identity($value)
{
  return $value;
}
