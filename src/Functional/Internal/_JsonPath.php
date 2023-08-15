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
 * @return array
 */
function _jsonPath($path)
{
  if (
    \is_string($path) &&
    \preg_match('/^(.){1,}|(\[\d\]){1,}$/i', $path)
  ) {
    return \explode(
      '.',
      \str_replace(['[', ']'], ['.', ''], $path)
    );
  }

  return $path;
}
