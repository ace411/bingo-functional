<?php

/**
 * endsWith function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const endsWith = __NAMESPACE__ . '\\endsWith';

/**
 * endsWith
 * checks if string ends with a specified string fragment
 *
 * endsWith :: String -> String -> Bool
 *
 * @param string $haystack
 * @param string $needle
 * @return boolean
 * @example
 *
 * endsWith('bingo-functional', 'nal')
 * => true
 */
function endsWith(string $haystack, string $needle): bool
{
  $strlen = \function_exists('mb_strlen') ? 
    \mb_strlen($needle, 'utf-8') : 
    \strlen($needle);

  if (equals($strlen, 0)) {
    return false;
  }

  return equals(\substr($haystack, -$strlen), $needle);
}
