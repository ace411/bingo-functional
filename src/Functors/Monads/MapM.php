<?php

/**
 * mapM
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\extend;
use function Chemem\Bingo\Functional\head;
use function Chemem\Bingo\Functional\size;
use function Chemem\Bingo\Functional\tail;

const mapM = __NAMESPACE__ . '\\mapM';

/**
 * mapM
 * analogous to map except its result is encapsulated in a monad
 *
 * mapM :: (a -> m b) -> [a] -> m [b]
 *
 * @param callable $function
 * @param array|object $list
 * @return Monad
 */
function mapM(callable $function, $list): Monad
{
  $monad  = $function(head($list));

  $map    = function ($collection) use (&$map, $function, $monad) {
    if (equals(size($collection), 0)) {
      return $monad::of($collection);
    }

    $tail = tail($collection);
    $head = head($collection);

    return bind(
      function ($result) use ($map, $tail, $head, $monad) {
        return bind(
          function ($ret) use ($head, $result, $monad) {
            $ret = extend([$result], $ret);

            return $monad::of($ret);
          },
          $map($tail)
        );
      },
      $function($head)
    );
  };

  return $map($list);
}
