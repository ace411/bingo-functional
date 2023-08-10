<?php

/**
 * _stdout
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO\Internal;

use Chemem\Bingo\Functional\Functors\Monads\IO;
use Chemem\Bingo\Functional\Functors\Monads\Monad;

const _stdout = __NAMESPACE__ . '\\_stdout';

/**
 * _stdout
 * handles printing to standard input device
 *
 * _stdout :: String -> IO
 *
 * @internal
 * @param string $string
 * @return IO
 */
function _stdout(string $string): Monad
{
  return IO::of(
    function () use ($string) {
      echo $string;

      // return \mb_strlen($string);
    }
  );
}
