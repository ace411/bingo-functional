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
  $strLen = \mb_strlen($needle, 'utf-8');

  if ($strLen === 0) {
    return false;
  }

  return \substr($haystack, -$strLen) === $needle;
}
