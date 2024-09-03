<?php

/**
 * writeFile
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

const writeFile = __NAMESPACE__ . '\\writeFile';

/**
 * writeFile
 * writes a string to a file.
 *
 * writeFile :: String -> String -> IO ()
 *
 * @param string $filePath
 * @param string $content
 * @return IO
 */
function writeFile(string $file, string $contents): Monad
{
  return IO(
    toException(
      function () use ($contents, $file) {
        if (\extension_loaded('eio')) {
          return _eio()
            ->write($file, $contents)
            ->exec();
        }

        $rbytes = @\file_put_contents($file, $contents);
        $error  = \error_get_last();

        if (!\is_null($error)) {
          throw new \Exception($error['message']);
        }

        return $rbytes;
      },
      function (\Throwable $err) {
        return IOException($err->getMessage())->exec();
      }
    )
  );
}
