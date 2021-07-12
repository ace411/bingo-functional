<?php

/**
 * assocPath
 *
 * @see https://ramdajs.com/docs/#assocPath
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const assocPath = __NAMESPACE__ . '\\assocPath';

/**
 * assocPath
 * creates a shallow clone of a list with an overwritten value assigned to the index
 * at the end of a traversable path
 *
 * assocPath :: [a] -> b -> [b] -> [b]
 *
 * @param array $keys
 * @param mixed $val
 * @param array|object $list
 * @return array|object
 * @example
 *
 * assocPath(['x', 1], 'foo', ['x' => range(1, 3)])
 * //=> ['x' => [1, 'foo', 3]]
 */
function assocPath(array $keys, $val, $list)
{
  $pathLen = \count($keys);
  if ($pathLen == 0) {
    return $list;
  }

  $idx = head($keys);
  if ($pathLen > 1) {
    $next = pluck($list, $idx);

    if (\is_object($next) || \is_array($next)) {
      $val = assocPath(dropLeft($keys, 1), $val, $next);
    }
  }

  return assoc($idx, $val, $list);
}
