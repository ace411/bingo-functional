<?php

/**
 * concat
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\extend;
use function Chemem\Bingo\Functional\fold;

const concat = __NAMESPACE__ . '\\concat';

/**
 * concat
 * creates a large list by merging multiple lists
 *
 * concat :: ListMonad [a] -> ListMonad [b] -> ListMonad [a, b]
 *
 * @param ListMonad $list
 * @return ListMonad
 */
function concat(Monad ...$list): Monad
{
  return fromValue(
    extend(
      ...fold(
        function (array $return, Monad $list) {
          $return[] = $list->extract();

          return $return;
        },
        $list,
        []
      )
    )
  );
}
