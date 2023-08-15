<?php

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

require_once __DIR__ . '/_FilterMaybeN.php';

use function Chemem\Bingo\Functional\extend;
use function Chemem\Bingo\Functional\partial;
use function Chemem\Bingo\Functional\partialRight;

use const Chemem\Bingo\Functional\every;

const _baseFilter = __NAMESPACE__ . '\\_baseFilter';

/**
 * _baseFilter
 * template for pattern structure checks
 *
 * _baseFilter :: [(a -> b)] -> ([(a -> b)] -> [c]) -> [c]
 *
 * @internal
 * @param array $patterns
 * @param callable $transformer
 * @return mixed
 */
function _baseFilter(
  $default,
  array $patterns,
  callable $success,
  callable ...$filters
) {
  return _filterMaybeN(
    $default,
    $patterns,
    $success,
    ...extend(
      [
        partial('key_exists', '_'),
        partialRight(every, 'is_callable'),
      ],
      $filters
    )
  );
}
