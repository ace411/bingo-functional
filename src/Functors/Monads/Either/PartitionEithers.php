<?php

/**
 * partitionEithers
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Either;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\fold;

const partitionEithers = __NAMESPACE__ . '\\partitionEithers';

/**
 * partitionEithers function
 * Partitions a list of Either into two lists.
 *
 * partitionEithers :: [Either a b] -> ([a], [b])
 *
 * @param array|object $eithers
 * @return array
 */
function partitionEithers($eithers)
{
  return fold(
    function (array $acc, Monad $either) {
      if ($either->isRight()) {
        $acc['right'][] = $either->getRight();
      } else {
        $acc['left'][] = $either->getLeft();
      }

      return $acc;
    },
    $eithers,
    []
  );
}
