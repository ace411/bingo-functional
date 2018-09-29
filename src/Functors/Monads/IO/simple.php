<?php

/**
 * 
 * IO monad STDIN/STDOUT helper functions
 * 
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use \Chemem\Bingo\Functional\Functors\Monads\IO as IOMonad;
use function \Chemem\Bingo\Functional\Algorithms\{compose, concat, identity, toException};

/**
 * 
 * IO function
 * initialize a value of type IO
 * 
 * IO :: Callable value -> IOMonad ()
 * 
 * @param mixed $value
 * @return object IO  
 */

const IO = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\IO';

function IO($value) : IOMonad
{
    return IOMonad::of($value);
}

/**
 * 
 * getChar function
 * Read a character from the standard input device
 * 
 * getChar :: IO Char
 * 
 * @return object IO
 */

const getChar = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\getChar';

function getChar() : IOMonad
{
    return putChar()
        ->map(function (callable $fget) { 
            return toException($fget)(\STDIN); 
        });
}

/**
 * 
 * putChar function
 * Write a character to the standard output device
 * 
 * putChar :: Char -> IO ()
 * 
 * @return object IO
 */

const putChar = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\putChar'; 
 
function putChar() : IOMonad
{
    return IO(function () {
        return compose('fgetc', 'trim');
    });
}

/**
 * 
 * putStr function
 * Write a string to the standard output device
 * 
 * putStr :: String -> IO ()
 * 
 * @return object IO
 */

const putStr = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\putStr';

function putStr() : IOMonad
{
    return IO(function () {
        return compose('fgets', 'trim');
    });
}

/**
 * 
 * getLine function
 * Read a line from the standard input device
 * 
 * getLine :: IO String
 * 
 * @return object IO
 */

const getLine = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\getLine';

function getLine() : IOMonad
{
    return putStr()
        ->map(function (callable $fget) { 
            $result = toException($fget)(\STDIN);

            return concat(\PHP_EOL, $result, identity(''));
        });
}

/**
 * 
 * interact function
 * Takes String->String function, parses standard input device input and conveys output to same standard device
 * 
 * interact :: (String -> String) -> IO ()
 * 
 * @param callable $function
 * @param object IO
 */

const interact = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\interact';

function interact(callable $function) : IOMonad
{
    return getLine()->map($function);
}

/**
 * 
 * _print function
 * Outputs a value of any printable type to the standard output device
 * 
 * _print :: Show a => a -> IO ()
 * 
 * @param object IO $interaction 
 * @return object IO
 */

const _print = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\_print';

function _print(IOMonad $interaction) : IOMonad
{
    return $interaction
        ->map(function (string $result) { 
            return printf('%s', concat(PHP_EOL, $result, identity(''))); 
        });
}