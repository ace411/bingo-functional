<?php

/**
 * fromValue
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const fromValue = __NAMESPACE__ . '\\fromValue';

/**
 * fromValue
 * puts an arbitrary value in a List monad
 *
 * fromValue :: a -> ListMonad [a]
 *
 * @param mixed $value
 * @return ListMonad
 */
function fromValue($value): Monad
{
  return (__NAMESPACE__ . '::of')($value);
}
