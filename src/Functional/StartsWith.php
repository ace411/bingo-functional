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
  $strlen = \function_exists('mb_strlen') ?
    \mb_strlen($needle, 'utf-8') :
    \strlen($needle);

  if (equals($strlen, 0)) {
    return false;
  }

  return equals(\substr($haystack, 0, $strlen), $needle);
}
