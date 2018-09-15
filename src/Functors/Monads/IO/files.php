<?php

namespace Chemem\Bingo\Functional\Functors\Monads\IO;

use \Chemem\Bingo\Functional\Functors\Monads\IO as IOMonad;
use function \Chemem\Bingo\Functional\Algorithms\{identity, toException, concat, constantFunction};

/**
 * readFile :: String -> IO String
 */

const readFile = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\readFile';

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

const writeFile = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\writeFile';

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

const appendFile = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\appendFile';

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

const readIO = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\IO\\readIO';

function readIO(IOMonad $getStr)
{
    //parse failure
    return $getStr
        ->map(function (string $input) { 
            return toException(constantFunction($input))(); 
        });
}
