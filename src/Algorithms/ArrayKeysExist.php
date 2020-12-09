<?php

/**
 * arrayKeysExist function.
 *
 * arrayKeysExist :: [a] b -> (b -> [a]) -> Bool c
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const arrayKeysExist = __NAMESPACE__ . '\\arrayKeysExist';

function arrayKeysExist(array $list, ...$keys): bool
{
  return keysExist($list, ...$keys);
}

const keysExist = __NAMESPACE__ . '\\keysExist';

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
