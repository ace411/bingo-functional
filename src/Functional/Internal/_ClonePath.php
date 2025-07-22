<?php

/**
 * _clonePath function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_CloneKey.php';

use function Chemem\Bingo\Functional\head;
use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\pluckPath;
use function Chemem\Bingo\Functional\size;

const _clonePath = __NAMESPACE__ . '\\_clonePath';

/**
 * _clonePath
 * creates an appropriate sublist from a single path-value pair in a list
 *
 * _clonePath :: Sum Array Object -> String -> a -> String -> Array
 *
 * @param array|object $list
 * @param string $path
 * @param mixed $value
 * @param string $separator
 * @return array|object
 */
function _clonePath(
  $list,
  string $path,
  $value,
  string $separator = '.'
) {
  if (\is_null($path)) {
    return $list;
  }

  $segments = \explode($separator, $path, 2);
  $key      = head($segments);

  if (
    equals(
      size($segments),
      1
    )
  ) {
    return _cloneKey($list, $key, $value);
  }

  $next = pluckPath($key, $list);

  if (
    \is_null($next) ||
    (
      \is_array($list) &&
      !\is_array($next)
    ) ||
    (
      \is_object($list) &&
      !\is_object($next)
    )
  ) {
    $list = _cloneKey(
      $list,
      $key,
      []
    );
  }

  return _cloneKey(
    $list,
    $key,
    _clonePath(
      $next,
      pluckPath('1', $segments),
      $value,
      $separator
    )
  );
}
