<?php

/**
 * lefts
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Either;

require_once __DIR__ . '/Internal/_Extract.php';

use Chemem\Bingo\Functional\Functors\Monads\Left;

use function Chemem\Bingo\Functional\Functors\Monads\Either\Internal\_extract;

const lefts = __NAMESPACE__ . '\\lefts';

/**
 * lefts function
 * Extracts from a list of Either all the Left elements.
 *
 * lefts :: [Either a b] -> [a]
 *
 * @param array|object $eithers
 * @return array
 */
function lefts($eithers)
{
  return _extract($eithers, Left::class);
}
