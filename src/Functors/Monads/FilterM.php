<?php

/**
 * filterM
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\dropRight;
use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\extend;
use function Chemem\Bingo\Functional\head;
use function Chemem\Bingo\Functional\tail;

const filterM = __NAMESPACE__ . '\\filterM';

/**
 * filterM
 * analogous to filter except its result is encapsulated in a monad
 *
 * filterM :: (a -> m a) -> [a] -> m [a]
 *
 * @param callable $function
 * @param array|object $list
 * @return Monad
 */
function filterM(callable $function, $list): Monad
{
  $monad = $function(head($list));

  $filter = function ($collection) use (&$filter, $function, $monad) {
    if (!$collection) {
      return $monad::of($collection);
    }

    $tail = tail($collection);
    $head = head($collection);

    return bind(
      function ($result) use ($tail, $monad, $head, $filter) {
        return bind(
          function ($ret) use ($result, $head, $monad) {
            if ($result) {
              $ret = extend([$head], $ret);
            }

            return $monad::of($ret);
          },
          $filter($tail)
        );
      },
      $function($head)
    );
  };

  return \is_object($list) ?
    bind(
      function ($result) use ($monad) {
        return $monad::of(dropRight($result));
      },
      $filter($list)
    ) :
    $filter($list);
}
