<?php

/**
 * putChar
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

require_once __DIR__ . '/Internal/_Stdout.php';

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\head;
use function Chemem\Bingo\Functional\Functors\Monads\IO\Internal\_stdout;

const putChar = __NAMESPACE__ . '\\putChar';

/**
 * putChar function
 * Write a character to the standard output device.
 *
 * putChar :: Char -> IO ()
 *
 * @param string $char
 * @return IO
 */
function putChar(string $char): Monad
{
  return _stdout(head(\str_split($char)));
}
