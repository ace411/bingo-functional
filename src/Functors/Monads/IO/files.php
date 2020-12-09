<?php

/**
 * IO monad file-interaction helper functions.
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:29
 *
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use Chemem\Bingo\Functional\Functors\Monads\IO as IOMonad;

use function Chemem\Bingo\Functional\Algorithms\identity;

/**
 * readFile function
 * Reads a file and returns the contents of the file as a string.
 *
 * readFile :: String -> IO String
 *
 * @param string $filePath
 *
 * @return object IO
 */

const readFile = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\readFile';

function readFile(string $filePath): IOMonad
{
  return IO($filePath)
    ->map(function (string $file) {
      return \is_file($file) ? @\file_get_contents($file) : identity('');
    });
}

/**
 * writeFile function
 * Writes a string to a file.
 *
 * writeFile :: String -> String -> IO ()
 *
 * @param string $filePath
 * @param string $content
 *
 * @return object IO
 */
const writeFile = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\writeFile';

function writeFile(string $filePath, string $content): IOMonad
{
  return IO($filePath)
    ->map(function (string $file) use ($content) {
      return \is_file($file) ? @\file_put_contents($file, $content) : identity(false);
    });
}

/**
 * appendFile function
 * Appends a string to a file.
 *
 * appendFile :: String -> String -> IO ()
 *
 * @param string $filePath
 * @param string $content
 *
 * @return object IO
 */
const appendFile = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\appendFile';

function appendFile(string $filePath, string $content): IOMonad
{
  return IO($filePath)
    ->map(function (string $file) use ($content) {
      return \is_file($file) ? @\file_put_contents($file, $content, \FILE_APPEND) : identity(false);
    });
}
