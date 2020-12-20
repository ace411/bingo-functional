<?php

/**
 * assocPath
 *
 * assocPath :: [a] -> b -> [b] -> [b]
 *
 * @see https://ramdajs.com/docs/#assocPath
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const assocPath = __NAMESPACE__ . '\\assocPath';

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
