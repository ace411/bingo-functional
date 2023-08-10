<?php

/**
 * readFile
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:29
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\toException;

const readFile = __NAMESPACE__ . '\\readFile';

/**
 * readFile function
 * reads a file and returns the contents of the file as a string.
 *
 * readFile :: String -> IO String
 *
 * @param string $filePath
 * @return IO
 */
function readFile(string $file): Monad
{
  return IO(
    toException(
      function () use ($file) {
        return \file_get_contents($file);
      },
      function ($err) {
        return IOException($err->getMessage())->exec();
      }
    )
  );
}
