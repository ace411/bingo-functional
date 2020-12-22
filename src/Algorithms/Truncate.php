<?php

/**
 * truncate function
 * 
 * @see https://lodash.com/docs/4.17.11#truncate
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

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
 * //=> 'lorem...'
 */
function truncate(string $string, int $limit): string
{
  $strlen = 0;
  $strlen += !\function_exists('mb_strlen') ?
    \strlen($string) :
    \mb_strlen($string, 'utf-8');

  $truncate = compose(
    partialRight('substr', $limit, 0),
    partialRight(partial(concat, '..'), '.')
  );

  return $limit > $strlen ? $string : $truncate($string);
}
