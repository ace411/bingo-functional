<?php

/**
 * mapWriter
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Writer-Lazy.html#g:2
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Writer;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const mapWriter = __NAMESPACE__ . '\\mapWriter';

/**
 * mapWriter
 * maps both the return value and output of a computation using the given
 *
 * mapWriter :: ((a, w) -> (b, w')) -> Writer w a -> Writer w' b
 *
 * @param callable $function
 * @param Writer
 * @return Writer
 */
function mapWriter(callable $function, Monad $writer): Monad
{
  [$result, $output] = $function(runWriter($writer));

  return writer($result, $output);
}
