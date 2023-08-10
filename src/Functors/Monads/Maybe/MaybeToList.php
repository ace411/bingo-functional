<?php

/**
 * maybeToList
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use Chemem\Bingo\Functional\Functors\Monads\Maybe;
use Chemem\Bingo\Functional\Functors\Monads\Monad;
use Chemem\Bingo\Functional\Functors\Monads\Nothing;

const maybeToList = __NAMESPACE__ . '\\maybeToList';

/**
 * maybeToList function
 * returns an empty list when given Nothing or a singleton list when not given Nothing.
 *
 * maybeToList :: Maybe a -> [a]
 *
 * @param Maybe $maybe
 * @return array
 */
function maybeToList(Monad $maybe): array
{
  return $maybe instanceof Nothing ? [] : [$maybe->getJust()];
}
