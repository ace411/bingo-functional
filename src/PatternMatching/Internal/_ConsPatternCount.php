<?php

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

use function Chemem\Bingo\Functional\compose;
use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\partial;

use const Chemem\Bingo\Functional\filter;
use const Chemem\Bingo\Functional\size;

const _consPatternCount = __NAMESPACE__ . '\\_consPatternCount';

/**
 * _consPatternCount
 * extracts number of items in cons pattern
 *
 * _consPatternCount :: String -> [Int]
 *
 * @internal
 * @param string $pattern
 * @return array
 * @example
 *
 * _consPatternCount('(x:xs:_)')
 * => ['(x:xs:_)' => 2]
 */
function _consPatternCount(string $pattern): array
{
  return [
    $pattern => compose(
      // check if underscore is present in pattern; propagate _ if absent
      function ($pttn) {
        return \preg_match('/([_])+/', $pttn) ? $pttn : '_';
      },
      // remove brackets from pattern
      partial('preg_replace', '/([(\)])+/', ''),
      // explode the pattern by colon (:)
      partial('explode', ':'),
      // take out non-underscore patterns
      partial(
        filter,
        function ($pttn) {
          return !equals($pttn, '_');
        }
      ),
      // count
      size
    )($pattern),
  ];
}
