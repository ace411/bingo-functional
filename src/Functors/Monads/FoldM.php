<?php

/**
 * foldM
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\head;
use function Chemem\Bingo\Functional\size;
use function Chemem\Bingo\Functional\tail;

const foldM = __NAMESPACE__ . '\\foldM';

/**
 * foldM
 * analogous to fold except its result is encapsulated within a monad.
 *
 * foldM :: (a -> b -> m a) -> [b] -> c -> m b
 *
 * @param callable $function
 * @param array|object $list
 * @param mixed $acc
 */
function foldM(callable $function, $list, $acc): Monad
{
  $monad = $function($acc, head($list));

  $fold = function ($acc, $collection) use (&$fold, $monad, $function) {
    if (equals(size($collection), 0)) {
      return $monad::of($acc);
    }

    $tail = tail($collection);
    $head = head($collection);

    return bind(
      function ($result) use ($tail, $fold) {
        return $fold($result, $tail);
      },
      $function($acc, $head)
    );
  };

  return $fold($acc, $list);
}
