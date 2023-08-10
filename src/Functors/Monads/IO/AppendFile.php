<?php

/**
 * appendFile
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:29
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\toException;

const appendFile = __NAMESPACE__ . '\\appendFile';

/**
 * appendFile
 * appends a string to a file
 *
 * appendFile :: String -> String -> IO ()
 *
 * @param string $filePath
 * @param string $content
 * @return IO
 */
function appendFile(string $file, string $contents): Monad
{
  return IO(
    toException(
      function () use ($contents, $file) {
        return \file_put_contents($file, $contents, FILE_APPEND);
      },
      function (\Throwable $err) {
        return IOException($err->getMessage())->exec();
      }
    )
  );
}
