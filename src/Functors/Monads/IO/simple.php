<?php

/**
 * IO monad STDIN/STDOUT helper functions.
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use Chemem\Bingo\Functional\Functors\Monads\Monad;
use Chemem\Bingo\Functional as f;

const IO = __NAMESPACE__ . '\\IO';

/**
 * IO
 * initializes a value of type IO
 *
 * IO :: a -> IO ()
 *
 * @param mixed $value
 * @return IO
 */
function IO($value): Monad
{
  return (__NAMESPACE__ . '::of')($value);
}

const getChar = __NAMESPACE__ . '\\getChar';

/**
 * getChar function
 * Read a character from the standard input device.
 *
 * getChar :: IO Char
 *
 * @return IO
 */
function getChar(): Monad
{
  $count = 0;

  return _readline(null, function ($_) use ($count) {
    $count += 1;

    return $count === 1;
  });
}

const _readline = __NAMESPACE__ . '\\_readline';

/**
 * _readline function
 * powered by ext-readline, the function reads string or character data from standard input device
 *
 * _readline :: String -> (String -> Bool) -> IO
 *
 * @internal
 * @param string $str
 * @param callable $handler
 * @return IO
 */
function _readline(string $str = null, callable $handler = null): Monad
{
  if (!\is_null($handler)) {
    return IO(function () use ($str, $handler) {
      \readline_callback_handler_install(!\is_string($str) ? '' : $str, $handler);
      \readline_callback_read_char();

      return f\concat('', PHP_EOL, \readline_info('line_buffer'));
    });
  }

  return IO(function () use ($str) {
    return \readline($str);
  });
}

const putChar = __NAMESPACE__ . '\\putChar';

/**
 * putChar function
 * Write a character to the standard output device.
 *
 * putChar :: Char -> IO ()
 *
 * @return IO
 */
function putChar(string $char): Monad
{
  return printToStdout($char);
}

const printToStdout = __NAMESPACE__ . '\\printToStdout';

/**
 * printToStdout function
 * handles printing to standard input device
 *
 * printToStdout :: String -> IO
 *
 * @internal
 * @param string $input
 * @return IO
 */
function printToStdout(string $input): Monad
{
  return IO(function () use ($input) {
    echo $input;
  });
}

const putStr = __NAMESPACE__ . '\\putStr';

/**
 * putStr
 * writes a string to the standard output device.
 *
 * putStr :: String -> IO ()
 *
 * @return IO
 */
function putStr(string $str): Monad
{
  return printToStdout($str);
}

const putStrLn = __NAMESPACE__ . '\\putStrLn';

/**
 * putStrLn function
 * Same as putStr but adds a newline character
 *
 * putStrLn :: String -> IO ()
 *
 * @param string $str
 * @return IO
 */
function putStrLn(string $str): Monad
{
  return printToStdout(f\concat('', $str, PHP_EOL));
}

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

const interact = __NAMESPACE__ . '\\interact';

/**
 * interact function
 * Takes String->String function, parses standard input device input and conveys output to same standard device.
 *
 * interact :: (String -> String) -> IO ()
 *
 * @param callable $function
 * @param IO
 */
function interact(callable $function): Monad
{
  return getLine()->map($function);
}

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
function _print(Monad $printable): Monad
{
  return $printable
    ->map(function (string $result) {
      return \printf('%s', f\concat(PHP_EOL, $result, f\identity('')));
    });
}

const IOException = __NAMESPACE__ . '\\IOException';

/**
 * IOException
 * safely throws an IO exception
 *
 * @param string $message
 * @return IO
 */
function IOException(string $message): Monad
{
  return IO(function () use ($message) {
    return function () use ($message) {
      throw new IOException($message);
    };
  });
}

const catchIO = __NAMESPACE__ . '\\catchIO';

/**
 * catchIO
 * catches an IO Exception in an IO monad environment
 *
 * catchIO :: IO a -> (IOException -> IO a) -> IO a
 *
 * @param IO $catch
 * @return IO
 */
function catchIO(Monad $catch): Monad
{
  return $catch->bind(function ($operation) {
    $exception = f\compose(f\toException, IO);

    return \is_callable($operation) ?
      $exception($operation) :
      $exception(function () use ($operation) {
        return $operation;
      });
  });
}
