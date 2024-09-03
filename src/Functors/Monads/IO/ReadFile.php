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

require_once __DIR__ . '/Internal/_Eio.php';

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\Functors\Monads\IO\Internal\_eio;
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
        // use ext-eio bindings
        if (\extension_loaded('eio')) {
          return _eio()
            ->read($file)
            ->exec();
        }

        $contents = @\file_get_contents($file);
        $error    = \error_get_last();

        if (!\is_null($error)) {
          throw new \Exception($error['message']);
        }

        return $contents;
      },
      function ($err) {
        return IOException($err->getMessage())->exec();
      }
    )
  );
}
