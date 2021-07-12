<?php

/**
 * Pattern matching functions.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

use Chemem\Bingo\Functional\PatternMatching\Internal as i;
use Chemem\Bingo\Functional\Algorithms as f;
use FunctionalPHP\PatternMatching as p;

const match = __NAMESPACE__ . '\\match';

/**
 * match
 * selectively evaluates cons-evaluable data
 *
 * match :: [([a] -> b)] -> [a] -> b
 *
 * @param array $patterns
 * @return callable
 * @example
 *
 * match([
 *  '(x:_)' => fn ($x) => $x + 10,
 *  '_' => fn () => 0,
 * ])([2])
 * //=> 12
 */
function match(array $patterns): callable
{
  // extract cons pattern counts
  $cons = i\filterMatch($patterns);

  return function (array $values) use ($patterns, $cons) {
    // return false on invalid cons data
    // perform match otherwise
    return empty($cons) ?
      false :
      i\execConsMatch($patterns, $cons, $values);
  };
}

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
 * //=> 'FOO'
 */
function patternMatch(array $patterns, $value)
{
  // operationalize base pattern filter for subsequent matches
  $match = f\partialRight(
    f\partial(i\baseFilter, false, $patterns),
    // apply value filter to Maybe filter context
    function ($_) use ($value) {
      return !empty($value);
    }
  );

  return \is_array($value) ?
    // use FunctionalPHP\PatternMatching primitives for array matches
    p\match($patterns, $value) :
    (
      // perform object match on detection of object input
      // perform string-based search otherwise
      \is_object($value) ?
        $match(f\partialRight(i\matchObject, $value)) :
        $match(f\partialRight(i\matchString, $value))
    );
}

const letIn = __NAMESPACE__ . '\\letIn';

/**
 * letIn function
 * destructures list elements via pattern matching - akin to the mechanism in Elm and Haskell
 *
 * letIn :: String -> [a, b] -> (Array -> ((a, b) -> c)) -> c
 *
 * @param array $params
 * @param array $list
 * @return callable
 * @example
 *
 * letIn('[a, b, _]', range(1, 3))('b', fn ($x) => $x ** 2)
 * //=> 4
 */
function letIn(string $pattern, array $items): callable
{
  // extract the tokens from the list
  $tokens = p\extract($pattern, $items);

  return function (array $keys, callable $func) use ($tokens) {
    // match keys against extracted tokens
    $args = f\fold(function (array $acc, string $key) use ($tokens) {
      if (isset($tokens[$key])) {
        $acc[] = $tokens[$key];
      }

      return $acc;
    }, $keys, []);

    return $func(...$args);
  };
}
