<?php

/**
 * toWords function
 *
 * @see https://lodash.com/docs/4.17.11#words
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const toWords = __NAMESPACE__ . '\\toWords';

/**
 * toWords
 * splits a string into an array of words via regex
 *
 * toWords :: String -> String -> [String]
 *
 * @param string $string
 * @param string $regex
 * @return array
 * @example
 *
 * toWords('lorem ipsum', '/[\s]+/')
 * => ['lorem', 'ipsum']
 */
function toWords(string $string, string $regex = ''): array
{
  return empty($regex) ?
    \explode(' ', $string) :
    \preg_split($regex, $string);
}
