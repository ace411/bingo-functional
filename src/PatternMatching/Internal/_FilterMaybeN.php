<?php

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

use Chemem\Bingo\Functional\Functors\Monads\Maybe;
use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\fold;
use function Chemem\Bingo\Functional\Functors\Monads\Maybe\maybe;

const _filterMaybeN = __NAMESPACE__ . '\\_filterMaybeN';

/**
 * _filterMaybeN
 * performs Maybe monad case analysis with multiple filter predicates
 *
 * _filterMaybeN :: b -> a -> (a -> b) -> [(a -> Bool)] -> b
 *
 * @internal
 * @param mixed $default
 * @param mixed $value
 * @param callable $success
 * @param callable ...$filters
 * @return mixed
 */
function _filterMaybeN(
  $default,
  $value,
  callable $success,
  callable ...$filters
) {
  return maybe(
    $default,
    $success,
    // apply multiple filters to Maybe type
    fold(
      function (Monad $maybe, callable $filter) {
        return $maybe->filter($filter);
      },
      $filters,
      Maybe::just($value)
    )
  );
}
