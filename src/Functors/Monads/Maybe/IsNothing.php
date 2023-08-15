<?php

/**
 * isNothing
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const isNothing = __NAMESPACE__ . '\\isNothing';

/**
 * isNothing function
 * returns True if its argument is of the form Nothing.
 *
 * isNothing :: Maybe a -> Bool
 *
 * @param Maybe $maybe
 * @return bool
 */
function isNothing(Monad $maybe): bool
{
  return \method_exists($maybe, 'isNothing') ?
    $maybe->isNothing() :
    false;
}
