<?php

/**
 * _fromKey
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Lens\Internal;

use function Chemem\Bingo\Functional\assoc;
use function Chemem\Bingo\Functional\pluck;

const _fromKey = __NAMESPACE__ . '\\_fromKey';

/**
 * _fromKey
 * creates a lens from a list index, functor-wrapped getter, and list
 *
 * _fromKey :: a -> (b -> f b) -> [b] -> f b
 *
 * @internal
 * @param mixed $key
 * @param callable $getter
 * @param mixed $list
 * @return object
 */
function _fromKey($key, callable $getter, $list)
{
  // transform key-specific value with getter
  return $getter(pluck($list, $key))
    ->map(
      function ($replacement) use ($list, $key) {
        // create shallow list clone
        return assoc($key, $replacement, $list);
      }
    );
}
