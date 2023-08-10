<?php

/**
 * prepend
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const prepend = __NAMESPACE__ . '\\prepend';

/**
 * prepend
 * inserts the items of one list into the beginning of another
 *
 * prepend :: ListMonad [a] -> ListMonad [b] -> ListMonad [a, b]
 *
 * @param ListMonad $value
 * @param ListMonad $list
 * @return ListMonad
 */
function prepend(Monad $value, Monad $list): Monad
{
  return concat($value, $list);
}
