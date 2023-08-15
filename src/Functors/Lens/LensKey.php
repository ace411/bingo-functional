<?php

/**
 * lensKey
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

require_once __DIR__ . '/Internal/_FromKey.php';

use function Chemem\Bingo\Functional\curry;

use const Chemem\Bingo\Functional\Functors\Lens\Internal\_fromKey;

const lensKey = __NAMESPACE__ . '\\lensKey';

/**
 * lensKey
 * creates a lens whose focus is an arbitrary list key
 *
 * lensKey :: a -> (b -> f b)
 *
 * @param mixed $key
 * @return callable
 */
function lensKey(string $key): callable
{
  return curry(_fromKey)($key);
}
