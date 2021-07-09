<?php

/**
 * Concat function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const concat = __NAMESPACE__ . '\\concat';

/**
 * concat
 * concatenates multiple string-coercible elements
 *
 * concat :: String -> [String] -> String
 *
 * @param string $glue
 * @param string ...$strings
 * @return string
 * @example
 *
 * concat('-', 'foo', 'bar', 1)
 * //=> 'foo-bar-1'
 */
function concat(string $glue = '', string ...$strings): string
{
  return \implode($glue, $strings);
}
