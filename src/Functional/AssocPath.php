<?php

/**
 * assocPath
 *
 * @see https://ramdajs.com/docs/#assocPath
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_JsonPath.php';

use function Chemem\Bingo\Functional\Internal\_jsonPath;

const assocPath = __NAMESPACE__ . '\\assocPath';

/**
 * assocPath
 * creates a shallow clone of a list with an overwritten value assigned to the index at the end of a traversable path
 *
 * assocPath :: [a] -> b -> [b] -> [b]
 *
 * @param array|string $path
 * @param mixed $val
 * @param array|object $list
 * @return array|object
 * @example
 *
 * assocPath(['x', 1], 'foo', ['x' => range(1, 3)])
 * => ['x' => [1, 'foo', 3]]
 */
function assocPath($path, $val, $list)
{
  $keys = _jsonPath($path);
  $tmp  = &$list;
  $idx  = 0;

  while ($keys) {
    $key = \array_shift($keys);

    if (\is_array($list)) {
      if (!\is_array($tmp)) {
        $tmp = [];
      }

      $tmp = &$tmp[$key];
    } elseif (\is_object($list)) {
      if (!\is_object($tmp)) {
        $tmp = (new \ReflectionClass($list))
          ->newInstanceWithoutConstructor();
      }

      $tmp = &$tmp->{$key};
    }
  }

  $tmp = $val;

  return $list;
}
