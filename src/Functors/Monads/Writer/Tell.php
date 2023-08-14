<?php

/**
 * tell
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Writer-Lazy.html#g:2
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Writer;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const tell = __NAMESPACE__ . '\\tell';

/**
 * tell
 * A that produces a Writer monad's output
 *
 * tell :: w -> m ()
 *
 * @param mixed $msg
 * @return Writer
 */
function tell($msg): Monad
{
  $writer = __NAMESPACE__;

  return new $writer(
    function () use ($msg) {
      return [null, [$msg]];
    }
  );
}
