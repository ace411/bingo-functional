<?php

/**
 * liftM
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\curry;
use function Chemem\Bingo\Functional\head;
use function Chemem\Bingo\Functional\fold;

const liftM = __NAMESPACE__ . '\\liftM';

/**
 * liftM
 * promotes a function to a monad
 *
 * liftM :: Monad m => (a -> r) -> m a -> m r
 *
 * @param callable $function
 * @param Monad ...$args
 * @return Monad
 */
function liftM(callable $function, Monad ...$args): Monad
{
  return fold(
    function ($monad, $arg) {
      return $monad->ap($arg);
    },
    $args,
    head($args)::of(curry($function))
  );
}
