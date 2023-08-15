<?php

/**
 * getChar
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

require __DIR__ . '/Internal/_Readline.php';

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\Functors\Monads\IO\Internal\_readline;

const getChar = __NAMESPACE__ . '\\getChar';

/**
 * getChar
 * Read a character from the standard input device
 *
 * getChar :: IO Char
 *
 * @return IO
 */
function getChar(): Monad
{
  $count = 0;

  return _readline(
    null,
    function ($_) use ($count) {
      $count += 1;

      return equals($count, 1);
    }
  );
}
