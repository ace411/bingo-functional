<?php

/**
 * fromJust
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use Chemem\Bingo\Functional\Functors\Monads\Monad;
use Chemem\Bingo\Functional\Functors\Monads\Nothing;

/**
 * Maybe Exception class
 */
class MaybeException extends \Exception
{
}

const fromJust = __NAMESPACE__ . '\\fromJust';

/**
 * fromJust function
 * extracts the element out of a Just and throws an error if its argument is Nothing
 *
 * fromJust :: Maybe a -> a
 *
 * @param Maybe $maybe
 * @return mixed
 */
function fromJust(Monad $maybe)
{
  if ($maybe instanceof Nothing) {
    throw new MaybeException('Maybe.fromJust: Nothing');
  }

  return $maybe->getJust();
}
