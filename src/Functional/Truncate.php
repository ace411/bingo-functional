<?php

/**
 * truncate function
 *
 * @see https://lodash.com/docs/4.17.11#truncate
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const truncate = __NAMESPACE__ . '\\truncate';

/**
 * truncate
 * outputs an arbitrary number of characters in a string and appends an ellipsis to the resultant string
 *
 * truncate :: String -> Int -> String
 *
 * @param string $string
 * @param integer $limit
 * @return string
 * @example
 *
 * truncate('lorem ipsum', 5)
 * => 'lorem...'
 */
function truncate(string $string, int $limit): string
{
  $lmbstr   = \extension_loaded('mbstring');
  $truncate = compose(
    partialRight(
      (
        $lmbstr ?
          '\mb_substr' :
          '\substr'
      ),
      $limit,
      0
    ),
    partial('\sprintf', '%s...'),
    // partialRight(partial(concat, '..'), '.')
  );

  return (
    $limit >
    (
      $lmbstr ?
        '\mb_strlen' :
        '\strlen'
    )($string)
  ) ?
    $string :
    $truncate($string);
}
