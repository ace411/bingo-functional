<?php

/**
 * catchIO
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\compose;
use function Chemem\Bingo\Functional\Functors\Monads\bind;

use const Chemem\Bingo\Functional\toException;

const catchIO = __NAMESPACE__ . '\\catchIO';

/**
 * catchIO
 * catches an IO Exception in an IO monad environment
 *
 * catchIO :: IO a -> (IOException -> IO a) -> IO a
 *
 * @param IO $catch
 * @return IO
 */
function catchIO(Monad $catch): Monad
{
  return bind(
    function ($operation) {
      return compose(toException, IO)(
        \is_callable($operation) ?
          $operation :
          function () use ($operation) {
            return $operation;
          }
      );
    },
    $catch
  );
}
