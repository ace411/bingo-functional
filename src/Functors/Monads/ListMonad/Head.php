<?php

/**
 * head
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const head = __NAMESPACE__ . '\\head';

/**
 * head
 * returns the first element in a list
 *
 * head :: ListMonad [a, b] -> a
 *
 * @param ListMonad $list
 * @return mixed
 */
function head(Monad $list)
{
  return $list->extract();
}
