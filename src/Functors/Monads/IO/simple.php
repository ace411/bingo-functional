<?php

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use \Chemem\Bingo\Functional\Functors\Monads\IO as IOMonad;
use function \Chemem\Bingo\Functional\Algorithms\{compose, concat, identity, toException};

/**
 * _return :: Callable value -> IOMonad ()
 */

const _return = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\_return';

function _return($value) : IOMonad
{
    return IOMonad::of($value);
}

/**
 * getChar :: IO Char
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
 * putChar :: Char -> IO ()
 */

const putChar = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\putChar'; 
 
function putChar() : IOMonad
{
    return _return(function () {
        return compose('fgetc', 'trim');
    });
}

/**
 * putStr :: String -> IO ()
 */

const putStr = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\putStr';

function putStr() : IOMonad
{
    return _return(function () {
        return compose('fgets', 'trim');
    });
}

/**
 * getLine :: IO String
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
 * putStrLn :: String -> IO ()
 */

const putStrLn = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\putStrLn';
 
function putStrLn() : IOMonad
{
    return putStr()
        ->map(function (callable $fget) { 
            return compose($fget, function (string $str) { return concat(\PHP_EOL, $str, ''); }); 
        });
}

/**
 * interact :: (String -> String) -> IO ()
 */

const interact = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\interact';

function interact(callable $function) : IOMonad
{
    return getLine()->map($function);
}

/**
 * _print :: Show a => a -> IO ()
 */

function _print(IOMonad $interaction) : IOMonad
{
    return $interaction
        ->map(function (string $result) { 
            return printf('%s', concat(PHP_EOL, $result, identity(''))); 
        });
}