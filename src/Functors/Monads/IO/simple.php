<?php

/**
 * IO monad STDIN/STDOUT helper functions.
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 *
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use Chemem\Bingo\Functional\Functors\Monads\IO as IOMonad;
use \Chemem\Bingo\Functional\Algorithms as A;
use function \Chemem\Bingo\Functional\PatternMatching\patternMatch as match;

/**
 * IO function
 * initialize a value of type IO.
 *
 * IO :: Callable value -> IOMonad ()
 *
 * @param mixed $value
 *
 * @return object IO
 */

const IO = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\IO';

function IO($value): IOMonad
{
    return IOMonad::of($value);
}

/**
 * getChar function
 * Read a character from the standard input device.
 *
 * getChar :: IO Char
 *
 * @return object IO
 */
const getChar = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\getChar';

function getChar(string $str = null): IOMonad
{
    $count = 0;
    return _readline($str, function ($ret) use ($count) {
        $count += 1;

        return $count === 1;
    });
}

const _readline = __NAMESPACE__ . '\\_readline';

/**
 * _readline function
 * powered by ext-readline, the function reads string or character data from standard input device
 * 
 * readline :: String -> (String -> Bool) -> IO
 * 
 * @param string $str
 * @param callable $handler
 * @return IO
 */
function _readline(string $str = null, callable $handler = null): IOMonad
{
    if (!is_null($handler)) {
        return IO(function () use ($str, $handler) {
            readline_callback_handler_install(!is_string($str) ? '' : $str, $handler);
            readline_callback_read_char();

            return A\concat('', PHP_EOL, readline_info('line_buffer'));
        });
    }

    return IO(function () use ($str) {
        return readline($str);
    });
}

/**
 * putChar function
 * Write a character to the standard output device.
 *
 * putChar :: Char -> IO ()
 *
 * @return object IO
 */
const putChar = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\putChar';

function putChar(string $char): IOMonad
{
    return printToStdout(mb_strlen($char, 'utf-8') === 1 ? $char : substr($char, 0, 1));
}

const printToStdout = __NAMESPACE__ . '\\printToStdout';

/**
 * printToStdout function
 * handles printing to standard input device
 * 
 * printToStdout :: String -> IO
 * 
 * @param string $input
 * @return IO
 */
function printToStdout(string $input): IOMonad
{
    $print = match([
        '"cli"' => function () use ($input) {
            return shell_exec(A\concat('', 'echo', ' ', '"', $input, '"'));
        },
        '_'     => function () use ($input) {
            return $input;
        }
    ], php_sapi_name());

    return IO(function () use ($print): int {
        return printf('%s', $print); // wrap side-effect inside IO instance
    });
}

/**
 * putStr function
 * Write a string to the standard output device.
 *
 * putStr :: String -> IO ()
 *
 * @return object IO
 */
const putStr = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\putStr';

function putStr(string $str): IOMonad
{
    return printToStdout($str);
}

/**
 * getLine function
 * Read a line from the standard input device.
 *
 * getLine :: IO String
 *
 * @return object IO
 */
const getLine = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\getLine';

function getLine(string $str = null): IOMonad
{
    return _readline($str);
}

/**
 * interact function
 * Takes String->String function, parses standard input device input and conveys output to same standard device.
 *
 * interact :: (String -> String) -> IO ()
 *
 * @param callable $function
 * @param object IO
 */
const interact = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\interact';

function interact(callable $function): IOMonad
{
    return getLine()->map($function);
}

/**
 * _print function
 * Outputs a value of any printable type to the standard output device.
 *
 * _print :: Show a => a -> IO ()
 *
 * @param object IO $interaction
 *
 * @return object IO
 */
const _print = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\_print';

function _print(IOMonad $interaction): IOMonad
{
    return $interaction
        ->map(function (string $result) {
            return printf('%s', A\concat(PHP_EOL, $result, A\identity('')));
        });
}

/**
 *
 * IOException function
 * throws an IO exception
 *
 * @param string $message
 * @return object IO
 */

const IOException = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\IOException';

function IOException(string $message): IOMonad
{
    return IO(function () use ($message) {
        return function () use ($message) {
            throw new IOException($message);
        };
    });
}

/**
 *
 * catchIO function
 * catches an IO Exception in an IO monad environment
 *
 * @param IO $exception
 * @return object IO
 */

const catchIO = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\catchIO';

function catchIO(IOMonad $operation): IOMonad
{
    return $operation->bind(function ($operation) {
        $exception = A\compose(A\toException, IO);
        return is_callable($operation) ?
            $exception($operation) :
            $exception(function () use ($operation) {
                return $operation;
            });
    });
}
