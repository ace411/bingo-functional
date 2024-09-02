<?php

/**
 * patternMatch
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

require_once __DIR__ . '/Parser/index.php';

use function Chemem\Bingo\Functional\PatternMatching\Parser\_match;

const patternMatch = __NAMESPACE__ . '\\patternMatch';

/**
 * patternMatch
 * performs elaborate selective evaluation of different data types
 *
 * patternMatch :: [(a -> b)] -> a -> b
 *
 * @param array $patterns
 * @param mixed $value
 * @return mixed
 * @example
 *
 * patternMatch([
 *  '[_, "foo"]' => fn () => strtoupper('foo'),
 *  '_' => fn () => 'undefined'
 * ], ['hello', 'foo'])
 * => 'FOO'
 */
function patternMatch(array $patterns, $value)
{
  if (!isset($patterns['_'])) {
    $patterns['_'] = function () {
      throw new \Exception('Could not find match for provided input');
    };
  }

  return _match(
    $patterns,
    (
      \is_object($value) ?
        \get_class($value) :
        $value
    )
  );
}
