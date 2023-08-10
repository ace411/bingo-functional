<?php

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

require_once __DIR__ . '/_ExecTypeMatch.php';

use function Chemem\Bingo\Functional\equals;

const _matchString = __NAMESPACE__ . '\\_matchString';

/**
 * _matchString
 * executes string, integer, and float pattern matches
 *
 * _matchString :: [(a -> b)] -> a -> b
 *
 * @internal
 * @param array $patterns
 * @param mixed $input
 * @return mixed
 * @example
 *
 * _matchString([
 *  '"12"' => fn () => 'exact',
 *  '_' => fn () => 'undef'
 * ], 12)
 * => 'exact'
 */
function _matchString(array $patterns, $input)
{
  return _execTypeMatch(
    $patterns,
    $input,
    function ($input, $pattern) {
      $compare = \preg_replace('/[\'\"]+/', '', $pattern);

      // handle comparisons between string, float, and integer types
      return \is_string($input) ?
        equals($input, $compare) :
        (
          \is_int($input) ?
            equals((int) $compare, $input) :
            (
              \is_float($input) ?
                equals((float) $compare, $input) :
                false
            )
        );
    }
  );
}
