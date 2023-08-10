<?php

/**
 * append
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const append = __NAMESPACE__ . '\\append';

/**
 * append
 * adds the items of one list to the end of another
 *
 * append :: ListMonad [a] -> ListMonad [b] -> ListMonad [b, a]
 *
 * @param ListMonad $value
 * @param ListMonad $list
 *
 * @return ListMonad
 */
function append(Monad $value, Monad $list): Monad
{
  return concat($list, $value);
}
