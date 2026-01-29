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
require_once __DIR__ . '/Internal/_Props.php';

use function Chemem\Bingo\Functional\Internal\_jsonPath;
use function Chemem\Bingo\Functional\Internal\_props;

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
 * @return array
 * @example
 *
 * assocPath(['x', 1], 'foo', ['x' => range(1, 3)])
 * => ['x' => [1, 'foo', 3]]
 */
function assocPath($path, $val, $list)
{
  $list = \is_object($list) ?
    _props($list) :
    $list;
  $keys = _jsonPath($path);
  $tmp  = &$list;
  $idx  = 0;

  while ($keys) {
    $key = \array_shift($keys);

    if (!\is_array($tmp)) {
      $tmp = [];
    }

    $tmp = &$tmp[$key];
  }

  $tmp = $val;

  return $list;
}
