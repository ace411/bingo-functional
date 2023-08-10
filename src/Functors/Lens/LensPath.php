<?php

/**
 * lensPath
 *
 * @see https://ramdajs.com/docs/#lens
 * @see https://medium.com/@dtipson/functional-lenses-d1aba9e52254
 * @see https://medium.com/javascript-scene/lenses-b85976cb0534
 * @see https://hackage.haskell.org/package/data-lens-light-0.1.2.2/docs/Data-Lens-Light.html#v:lens
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Lens;

use function Chemem\Bingo\Functional\curry;

use const Chemem\Bingo\Functional\assocPath;
use const Chemem\Bingo\Functional\pluckPath;

const lensPath = __NAMESPACE__ . '\\lensPath';

/**
 * lensPath
 * creates a lens from a path
 *
 * lensPath :: [b] -> Lens s a
 *
 * @param mixed ...$fragments
 * @return callable
 */
function lensPath(...$fragments): callable
{
  return lens(
    curry(pluckPath)($fragments),
    curry(assocPath)($fragments)
  );
}
