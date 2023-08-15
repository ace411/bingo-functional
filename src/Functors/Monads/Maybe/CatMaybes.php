<?php

/**
 * catMaybes
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use Chemem\Bingo\Functional\Functors\Monads\Just;
use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\fold;

const catMaybes = __NAMESPACE__ . '\\catMaybes';

/**
 * catMaybes function
 * takes a list of Maybes and returns a list of all the Just values.
 *
 * catMaybes :: [Maybe a] -> [a]
 *
 * @param array|object $maybes
 * @return array
 */
function catMaybes($maybes)
{
  return fold(
    function ($list, Monad $maybe, $idx) {
      if ($maybe instanceof Just) {
        if (\is_object($list)) {
          $list->{$idx} = $maybe->getJust();
        } elseif (\is_array($list)) {
          $list[$idx] = $maybe->getJust();
        }
      } else {
        if (\is_object($list)) {
          unset($list->{$idx});
        } else {
          unset($list[$idx]);
        }
      }

      return $list;
    },
    $maybes,
    $maybes
  );
}
