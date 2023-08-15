<?php

/**
 * isJust
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const isJust = __NAMESPACE__ . '\\isJust';

/**
 * isJust function
 * returns True if its argument is of the form Just.
 *
 * isJust :: Maybe a -> Bool
 *
 * @param Maybe $maybe
 * @return bool
 */
function isJust(Monad $maybe): bool
{
  return \method_exists($maybe, 'isJust') ?
    $maybe->isJust() :
    false;
}
