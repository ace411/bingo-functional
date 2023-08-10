<?php

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

use function Chemem\Bingo\Functional\compose;
use function Chemem\Bingo\Functional\partial;
use function Chemem\Bingo\Functional\partialRight;

use const Chemem\Bingo\Functional\head;
use const Chemem\Bingo\Functional\filter;
use const Chemem\Bingo\Functional\pluck;

const _execTypeMatch = __NAMESPACE__ . '\\_execTypeMatch';

/**
 * _execTypeMatch
 * uses arbitrary comparator in pattern matching operations
 *
 * _execTypeMatch :: [(a -> b)] -> a -> (a -> c -> Bool) -> b
 *
 * @internal
 * @param array $patterns
 * @param mixed $input
 * @param callable $comparator
 * @return mixed
 */
function _execTypeMatch(
  array $patterns,
  $input,
  callable $comparator
) {
  // memoize pattern list key extraction
  $pluck = partial(pluck, $patterns);

  return compose(
    'array_keys',
    // strip down the pattern & apply comparator to check for exactness
    partial(filter, partial($comparator, $input)),
    head,
    // extract function and call it; call wildcard case otherwise
    partialRight($pluck, $pluck('_'))
  )($patterns)();
}
