<?php

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

require_once __DIR__ . '/Internal/_Stdout.php';

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\Functors\Monads\IO\Internal\_stdout;

const _print = __NAMESPACE__ . '\\_print';

/**
 * _print
 * Outputs a value of any printable type to the standard output device.
 *
 * _print :: Show a => a -> IO ()
 *
 * @param IO $printable
 * @return IO
 */
function _print(string $string): Monad
{
  return _stdout($string);
}
