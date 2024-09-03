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
  $lmbstr = \extension_loaded('mbstring');
  $strlen = (
    $lmbstr ?
      '\mb_strlen' :
      '\strlen'
  )($needle);

  return $strlen > 0 ?
    equals(
      (
        $lmbstr ?
          '\mb_substr' :
          '\substr'
      )(
        $haystack,
        0,
        $strlen
      ),
      $needle
    ) :
    false;
}
