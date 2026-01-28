<?php

/**
 * arrayKeysExist function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const arrayKeysExist = __NAMESPACE__ . '\\arrayKeysExist';

/**
 * arrayKeysExist
 * checks if multiple keys exist in an array
 *
 * arrayKeysExist :: [a, b] -> c -> d -> Bool
 *
 * @param array $list
 * @param string|integer ...$keys
 * @return boolean
 * @example
 *
 * arrayKeysExist(['foo' => 'foo', 1 => 'baz'], 1, 'baz')
 * => false
 */
function arrayKeysExist(array $list, ...$keys): bool
{
  return keysExist($list, ...$keys);
}

const keysExist = __NAMESPACE__ . '\\keysExist';

/**
 * keysExist
 * checks if multiple keys exist in a list
 *
 * keysExist :: [a, b] -> c -> d -> Bool
 *
 * @param array|object $list
 * @param string|integer ...$keys
 * @return boolean
 * @example
 *
 * keysExist((object) ['foo' => 'foo', 1 => 'baz'], 1, 'baz')
 * => false
 */
function keysExist($list, ...$keys): bool
{
  $exist    = false;
  $matches  = 0;
  $idx      = 0;

  while (isset($keys[$idx])) {
    $next = $keys[$idx];

    if (\is_object($list)) {
      if (isset($list->{$next})) {
        $matches += 1;
      }
    }

    if (\is_array($list)) {
      if (isset($list[$next])) {
        $matches += 1;
      }
    }

    if (!isset($keys[$idx + 1]) && equals($matches, $idx + 1)) {
      $exist = true;
    }

    $idx++;
  }

  return $exist;
}
