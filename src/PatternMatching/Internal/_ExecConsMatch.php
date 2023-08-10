<?php

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

use function Chemem\Bingo\Functional\compose;
use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\head;
use function Chemem\Bingo\Functional\partial;
use function Chemem\Bingo\Functional\size;

use const Chemem\Bingo\Functional\filter;
use const Chemem\Bingo\Functional\pluck;

const _execConsMatch = __NAMESPACE__ . '\\_execConsMatch';

/**
 * _execConsMatch
 * executes cons pattern match
 *
 * _execConsMatch :: [(a -> b)] -> [Int] -> [a] -> b
 *
 * @internal
 * @param array $patterns
 * @param array $cons
 * @param array $values
 * @return mixed
 * @example
 *
 * _execConsMatch(
 *  [
 *    '(x:_)' => fn ($x) => $x + 10,
 *    '_' => fn () => 0
 *  ],
 *  ['(x:_)' => 1, '_' => 0],
 *  [3]
 * )
 * => 13
 */
function _execConsMatch(
  array $patterns,
  array $cons,
  array $values
) {
  return compose(
    // get pattern whose cons count matches value count
    partial(
      filter,
      function ($count) use ($values) {
        return equals($count, size($values));
      }
    ),
    // extract first element from list
    'array_keys',
    // extract key that matches pattern
    function ($keys) {
      return empty($keys) ? '_' : head($keys);
    },
    // extract executable function that matches apt pattern in pattern list
    partial(pluck, $patterns)
  )($cons)(...$values);
}
