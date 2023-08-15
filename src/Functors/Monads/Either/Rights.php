<?php

/**
 * rights
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Either;

require_once __DIR__ . '/Internal/_Extract.php';

use Chemem\Bingo\Functional\Functors\Monads\Right;

use function Chemem\Bingo\Functional\Functors\Monads\Either\Internal\_extract;

const rights = __NAMESPACE__ . '\\rights';

/**
 * rights function
 * Extracts from a list of Either all the Right elements
 *
 * rights :: [Either a b] -> [b]
 *
 * @param array|object $eithers
 * @return array
 */
function rights($eithers)
{
  return _extract($eithers, Right::class);
}
