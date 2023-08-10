<?php

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

require_once __DIR__ . '/_BaseFilter.php';
require_once __DIR__ . '/_ConsEachCount.php';

use function Chemem\Bingo\Functional\compose;

const _filterMatch = __NAMESPACE__ . '\\_filterMatch';

/**
 * _filterMatch
 * validates cons list and computes cons counts on success; returns an empty array otherwise
 *
 * _filterMatch :: [String] -> [Int]
 *
 * @internal
 * @param array $patterns
 * @return array
 * @example
 *
 * _filterMatch()
 * =>
 */
function _filterMatch(array $patterns): array
{
  return _baseFilter(
    [],
    $patterns,
    compose('array_keys', _consEachCount)
  );
}
