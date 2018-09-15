<?php

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use \Chemem\Bingo\Functional\Functors\Monads\IO as IOMonad;
use function \Chemem\Bingo\Functional\Algorithms\{identity, toException, concat};

/**
 * readFile :: String -> IO String
 */

function readFile(string $filePath) : IOMonad
{
    return _return($filePath)
        ->map(function (string $file) { 
            return is_file($file) ? @file_get_contents($file) : identity(''); 
        });    
}

/**
 * writeFile :: String -> String -> IO ()
 */

function writeFile(string $filePath, string $content) : IOMonad
{
    return _return($filePath)
        ->map(function (string $file) use ($content) {
            return is_file($file) ? @file_put_contents($file, $content) : identity(false);
        });
}

/**
 * appendFile :: String -> String -> IO ()
 */

function appendFile(string $filePath, string $content) : IOMonad
{
    return _return($filePath)
        ->map(function (string $file) use ($content) {
            return is_file($file) ? @file_put_contents($file, $content, \FILE_APPEND) : identity(false);
        });
}

/**
 * readIO :: Read a => String -> IO a
 */

function readIO(IO $getStr)
{
    //parse failure
    return $getStr
        ->map(function (string $input) { 
            return toException(concat(\PHP_EOL, $input, '')); 
        });
}
