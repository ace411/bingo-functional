<?php

/**
 * patternMatch
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

require_once __DIR__ . '/Internal/_BaseFilter.php';
require_once __DIR__ . '/Internal/_MatchObject.php';
require_once __DIR__ . '/Internal/_MatchString.php';

use function Chemem\Bingo\Functional\fold;
use function Chemem\Bingo\Functional\partial;
use function Chemem\Bingo\Functional\partialRight;
use function FunctionalPHP\PatternMatching\pmatch;

use const Chemem\Bingo\Functional\PatternMatching\Internal\_baseFilter;
use const Chemem\Bingo\Functional\PatternMatching\Internal\_matchObject;
use const Chemem\Bingo\Functional\PatternMatching\Internal\_matchString;

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
  // operationalize base pattern filter for subsequent matches
  $match = partialRight(
    partial(_baseFilter, false, $patterns),
    // apply value filter to Maybe filter context
    function ($_) use ($value) {
      return !empty($value);
    }
  );

  return \is_array($value) ?
    // use FunctionalPHP\PatternMatching primitives for array matches
    pmatch($patterns, $value) :
    (
      // perform object match on detection of object input
      // perform string-based search otherwise
      \is_object($value) ?
        $match(partialRight(_matchObject, $value)) :
        $match(partialRight(_matchString, $value))
    );
}
