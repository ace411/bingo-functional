<?php

/**
 * putStr
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

require_once __DIR__ . '/Internal/_Stdout.php';

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\Functors\Monads\IO\Internal\_stdout;

const putStr = __NAMESPACE__ . '\\putStr';

/**
 * putStr
 * writes a string to the standard output device.
 *
 * putStr :: String -> IO ()
 *
 * @param string $string
 * @return IO
 */
function putStr(string $string): Monad
{
  return _stdout($string);
}
