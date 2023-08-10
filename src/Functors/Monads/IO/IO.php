<?php

/**
 * IO
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const IO = __NAMESPACE__ . '\\IO';

/**
 * IO
 * initializes a value of type IO
 *
 * IO :: a -> IO ()
 *
 * @param mixed $value
 * @return IO
 */
function IO($value): Monad
{
  return (__NAMESPACE__ . '::of')($value);
}
