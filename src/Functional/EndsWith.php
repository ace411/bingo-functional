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
      )($haystack, -$strlen),
      $needle
    ) :
    false;
}
