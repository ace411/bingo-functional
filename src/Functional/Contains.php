<?php

/**
 * contains function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const contains = __NAMESPACE__ . '\\contains';

/**
 * contains
 * Checks if a string exists in another string
 *
 * contains :: String -> String -> Bool
 *
 * @param string $haystack
 * @param string $needle
 * @return boolean
 * @example
 *
 * contains('bingo-functional', 'func')
 * => true
 */
function contains(string $haystack, string $needle): bool
{
  return !equals(
    (
      \extension_loaded('mbstring') ?
        '\mb_stripos' :
        '\stripos'
    )($haystack, $needle),
    false
  );
}
