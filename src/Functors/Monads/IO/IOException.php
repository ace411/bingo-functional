<?php

/**
 * IOException
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

/**
 * IO Exception class
 */
class IOException extends \Exception
{
}

const IOException = __NAMESPACE__ . '\\IOException';

/**
 * IOException
 * safely throws an IO exception
 *
 * @param string $message
 * @return IO
 */
function IOException(string $message): Monad
{
  return IO(
    function () use ($message) {
      return function () use ($message) {
        throw new IOException($message);
      };
    }
  );
}
