<?php

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use \Chemem\Bingo\Functional\Functors\Monads\IO as IOMonad;
use function \Chemem\Bingo\Functional\Algorithms\{compose, concat, identity, toException};

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

function putChar() : IOMonad
{
    return _return(function () {
        return compose('fgetc', 'trim');
    });
}

/**
 * putStr :: String -> IO ()
 */

function putStr() : IOMonad
{
    return _return(function () {
        return compose('fgets', 'trim');
    });
}

/**
 * getLine :: IO String
 */

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