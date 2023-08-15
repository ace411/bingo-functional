<?php

/**
 * getLine
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

require_once __DIR__ . '/Internal/_Readline.php';

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\Functors\Monads\IO\Internal\_readline;

const getLine = __NAMESPACE__ . '\\getLine';

/**
 * getLine
 * Read a line from the standard input device.
 *
 * getLine :: IO String
 *
 * @return IO
 */
function getLine(): Monad
{
  return _readline(null);
}
