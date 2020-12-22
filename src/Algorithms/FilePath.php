<?php

/**
 * filePath function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const filePath = __NAMESPACE__ . '\\filePath';

/**
 * filePath
 * outputs the absolute path to a file or directory
 * 
 * filePath :: Int -> String -> String
 *
 * @param integer $level
 * @param string ...$components
 * @return string
 * @example
 * 
 * filePath(0, 'path', 'to', 'file')
 * //=> '/basedir/path/to/file'
 */
function filePath(int $level, string ...$components): string
{
  return concat('/', \dirname(__DIR__, 5 + $level), ...$components);
}
