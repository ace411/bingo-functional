<?php

/**
 * pluckPath
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_JsonPath.php';

use function Chemem\Bingo\Functional\Internal\_jsonPath;

const pluckPath = __NAMESPACE__ . '\\pluckPath';

/**
 * pluckPath
 * returns the item that corresponds to the index at the end of a traversable path
 *
 * pluckPath :: a -> [b] -> c -> b
 *
 * @param string|array $path
 * @param array|object $list
 * @param mixed $default
 * @return mixed
 *
 * pluckPath('x.foo', ['x' => ['foo' => 3]])
 * => 3
 */
function pluckPath($path, $list, $default = null)
{
  return fold(
    function ($acc, $key) use ($default) {
      if (\is_object($acc)) {
        $acc = isset($acc->{$key}) ? $acc->{$key} : null;
      } elseif (\is_array($acc) || \is_iterable($acc)) {
        $acc = isset($acc[$key]) ? $acc[$key] : null;
      }

      return \is_null($acc) ? $default : $acc;
    },
    _jsonPath($path),
    $list
  );
}
