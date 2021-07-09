<?php

/**
 * arrayKeysExist function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

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
 * //=> false
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
 * //=> false
 */
function keysExist($list, ...$keys): bool
{
  $check = _fold(function ($acc, $val, $idx) use ($keys) {
    if (\in_array($idx, $keys)) {
      $acc[] = $val;
    }

    return $acc;
  }, $list, []);

  return \count($check) == \count($keys);
}
