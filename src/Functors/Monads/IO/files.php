<?php

/**
 * IO monad file-interaction helper functions.
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:29
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\Algorithms\identity;

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
function readFile(string $filePath): Monad
{
  return IO($filePath)
    ->map(function (string $file) {
      return \is_file($file) ?
        @\file_get_contents($file) :
        identity('');
    });
}

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
function writeFile(string $filePath, string $content): Monad
{
  return IO($filePath)
    ->map(function (string $file) use ($content) {
      return \is_file($file) ? @\file_put_contents($file, $content) : identity(false);
    });
}

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
function appendFile(string $filePath, string $content): Monad
{
  return IO($filePath)
    ->map(function (string $file) use ($content) {
      return \is_file($file) ?
        @\file_put_contents($file, $content, \FILE_APPEND) :
        identity(false);
    });
}
