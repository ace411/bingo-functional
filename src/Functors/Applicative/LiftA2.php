<?php

/**
 * liftA2
 *
 * @see https://hackage.haskell.org/package/rio-0.1.22.0/docs/RIO-Prelude.html#v:liftA2
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicative;

use Chemem\Bingo\Functional\Functors\ApplicativeFunctor;

use function Chemem\Bingo\Functional\map;

const liftA2 = __NAMESPACE__ . '\\liftA2';

/**
 * liftA2 function
 * Lift a binary function to actions.
 *
 * liftA2 :: (a -> b -> c) -> f a -> f b -> f c
 *
 * @param callable $function
 * @param ApplicativeFunctor ...$values
 * @return ApplicativeFunctor
 */
function liftA2(callable $function, ApplicativeFunctor ...$values): ApplicativeFunctor
{
  return pure(
    $function(
      ...map(
        function (ApplicativeFunctor $val) {
          return $val->getValue();
        },
        $values
      )
    )
  );
}
