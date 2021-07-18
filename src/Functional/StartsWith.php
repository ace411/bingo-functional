<?php

/**
 * startsWith function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const startsWith = __NAMESPACE__ . '\\startsWith';

/**
 * startsWith
 * checks if string starts with specified string fragment
 *
 * startsWith :: String -> String -> Bool
 *
 * @param string $haystack
 * @param string $needle
 * @return boolean
 * @example
 *
 * startsWith('bingo-functional', 'function')
 * => false
 */
function startsWith(string $haystack, string $needle): bool
{
  $strlen = \mb_strlen($needle, 'utf-8');

  if ($strlen === 0) {
    return false;
  }

  return \substr($haystack, 0, $strlen) === $needle;
}
