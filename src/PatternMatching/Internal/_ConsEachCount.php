<?php

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

require_once __DIR__ . '/_ConsPatternCount.php';

use function Chemem\Bingo\Functional\compose;
use function Chemem\Bingo\Functional\extend;
use function Chemem\Bingo\Functional\partial;

use const Chemem\Bingo\Functional\map;

const _consEachCount = __NAMESPACE__ . '\\_consEachCount';

/**
 * _consEachCount
 * gets cons count for each pattern in list
 *
 * _consEachCount :: [String] -> [Int]
 *
 * @internal
 * @param array $cons
 * @return array
 * @example
 *
 * _consEachCount(['(x:xs:_)', '(x:_)'])
 * => ['(x:xs:_)' => 2, '(x:_)' => 1]
 */
function _consEachCount(array $cons): array
{
  return compose(
    // get cons count for each cons pattern
    partial(map, _consPatternCount),
    // recursively merge each pattern
    function (array $cons) {
      return extend(...$cons);
    }
  )($cons);
}
