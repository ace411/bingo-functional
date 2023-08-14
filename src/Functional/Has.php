<?php

/**
 * has function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const has = __NAMESPACE__ . '\\has';

/**
 * has
 * checks if list contains a specified value
 *
 * has :: [a] -> b -> Bool
 *
 * @param array|object $haystack
 * @param mixed $needle
 * @return bool
 * @example
 *
 * has([range(1, 5), 'foo', 'bar'], 3)
 * => true
 */
function has($haystack, $needle): bool
{
  return fold(
    function (bool $exists, $entry) use ($needle) {
      if (equals($needle, $entry, true)) {
        return true;
      }

      if (\is_object($entry) || \is_array($entry)) {
        $exists = has($entry, $needle);
      }

      return $exists;
    },
    $haystack,
    false
  );
}
