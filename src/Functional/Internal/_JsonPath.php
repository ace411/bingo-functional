<?php

/**
 * _jsonPath function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

const _jsonPath = __NAMESPACE__ . '\\_jsonPath';

/**
 * _jsonPath
 * prints an array version of a JSON path
 *
 * _jsonPath :: a -> a
 *
 * @internal
 * @param array|string $path
 * @return mixed
 */
function _jsonPath($path, string $separator = '.')
{
  return \is_string($path) ?
    \preg_split(
      \sprintf(
        '/(%s){1}/',
        \preg_quote($separator, '/')
      ),
      \preg_replace(
        [
          '/(\[){1}/',
          '/(\]){1}/',
          '/(\"){1}/'
        ],
        [
          $separator,
          '',
          '',
        ],
        $path
      )
    ) :
    $path;
}
