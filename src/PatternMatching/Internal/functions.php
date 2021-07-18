<?php

/**
 * Internal pattern matching functions
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Functors\Monads\Maybe;
use Chemem\Bingo\Functional\Functors\Monads\Monad;

const consPatternCount = __NAMESPACE__ . '\\consPatternCount';

/**
 * consPatternCount
 * extracts number of items in cons pattern
 *
 * consPatternCount :: String -> [Int]
 *
 * @internal
 * @param string $pattern
 * @return array
 * @example
 *
 * consPatternCount('(x:xs:_)')
 * => ['(x:xs:_)' => 2]
 */
function consPatternCount(string $pattern): array
{
  $count = f\compose(
    // check if underscore is present in pattern; propagate _ if absent
    function ($pttn) {
      return \preg_match('/([_])+/', $pttn) ? $pttn : '_';
    },
    // remove brackets from pattern
    f\partial('preg_replace', '/([(\)])+/', ''),
    // explode the pattern by colon (:)
    f\partial('explode', ':'),
    // take out non-underscore patterns
    f\partial(f\filter, function ($pttn) {
      return $pttn !== '_';
    }),
    // count
    'count'
  );

  return [$pattern => $count($pattern)];
}

const consEachCount = __NAMESPACE__ . '\\consEachCount';

/**
 * consEachCount
 * gets cons count for each pattern in list
 *
 * consEachCount :: [String] -> [Int]
 *
 * @internal
 * @param array $cons
 * @return array
 * @example
 *
 * consEachCount(['(x:xs:_)', '(x:_)'])
 * => ['(x:xs:_)' => 2, '(x:_)' => 1]
 */
function consEachCount(array $cons): array
{
  $count = f\compose(
    // get cons count for each cons pattern
    f\partial(f\map, consPatternCount),
    // recursively merge each pattern
    function (array $cons) {
      return f\extend(...$cons);
    }
  );

  return $count($cons);
}

const filterMatch = __NAMESPACE__ . '\\filterMatch';

/**
 * filterMatch
 * validates cons list and computes cons counts on success; returns
 * an empty array otherwise
 *
 * filterMatch :: [String] -> [Int]
 *
 * @internal
 * @param array $patterns
 * @return array
 * @example
 *
 * filterMatch()
 * =>
 */
function filterMatch(array $patterns): array
{
  return baseFilter(
    [],
    $patterns,
    f\compose('array_keys', consEachCount)
  );
}

const execConsMatch = __NAMESPACE__ . '\\execConsMatch';

/**
 * execConsMatch
 * executes cons pattern match
 *
 * execConsMatch :: [(a -> b)] -> [Int] -> [a] -> b
 *
 * @internal
 * @param array $patterns
 * @param array $cons
 * @param array $values
 * @return mixed
 * @example
 *
 * execConsMatch(
 *  [
 *    '(x:_)' => fn ($x) => $x + 10,
 *    '_' => fn () => 0
 *  ],
 *  ['(x:_)' => 1, '_' => 0],
 *  [3]
 * )
 * => 13
 */
function execConsMatch(
  array $patterns,
  array $cons,
  array $values
) {
  $exec = f\compose(
    // get pattern whose cons count matches value count
    f\partial(f\filter, function ($count) use ($values) {
      return $count === \count($values);
    }),
    // extract first element from list
    'array_keys',
    f\head,
    // extract executable function from pattern list
    f\partialRight(f\partial(f\pluck, $patterns), '_')
  );

  return $exec($cons)(...$values);
}

const matchString = __NAMESPACE__ . '\\matchString';

/**
 * matchString
 * executes string, integer, and float pattern matches
 *
 * matchString :: [(a -> b)] -> a -> b
 *
 * @internal
 * @param array $patterns
 * @param mixed $input
 * @return mixed
 * @example
 *
 * matchString([
 *  '"12"' => fn () => 'exact',
 *  '_' => fn () => 'undef'
 * ], 12)
 * => 'exact'
 */
function matchString(array $patterns, $input)
{
  return execTypeMatch(
    $patterns,
    $input,
    function ($input, $pattern) {
      $compare = \preg_replace('/[\'\"]+/', '', $pattern);

      // handle comparisons between string, float, and integer types
      return \is_string($input) ?
        $input === $compare :
        (
          \is_int($input) ?
            (int) $compare === $input :
            (
              \is_float($input) ?
                (float) $compare === $input :
                false
            )
        );
    }
  );
}

const matchObject = __NAMESPACE__ . '\\matchObject';

/**
 * matchObject
 * executes explicit object pattern matches
 *
 * matchObject :: [(a -> b)] -> a -> b
 *
 * @internal
 * @param array $patterns
 * @param object $input
 * @return mixed
 * @example
 *
 * matchObject([
 *  stdClass::class => fn () => 'exact',
 *  '_' => fn () => 'undef'
 * ], new stdClass(12))
 * => 'exact'
 */
function matchObject(array $patterns, $input)
{
  return execTypeMatch(
    $patterns,
    $input,
    function ($input, $pattern) {
      return \get_class($input) === $pattern;
    }
  );
}

const execTypeMatch = __NAMESPACE__ . '\\execTypeMatch';

/**
 * execTypeMatch
 * uses arbitrary comparator in pattern matching operations
 *
 * execTypeMatch :: [(a -> b)] -> a -> (a -> c -> Bool) -> b
 *
 * @internal
 * @param array $patterns
 * @param mixed $input
 * @param callable $comparator
 * @return mixed
 */
function execTypeMatch(
  array $patterns,
  $input,
  callable $comparator
) {
  // memoize pattern list key extraction
  $pluck = f\partial(f\pluck, $patterns);
  $exec  = f\compose(
    'array_keys',
    // strip down the pattern & apply comparator to check for exactness
    f\partial(f\filter, f\partial($comparator, $input)),
    f\head,
    // extract function and call it; call wildcard case otherwise
    f\partialRight($pluck, $pluck('_'))
  );

  return $exec($patterns)();
}

const baseFilter = __NAMESPACE__ . '\\baseFilter';

/**
 * baseFilter
 * template for pattern structure checks
 *
 * baseFilter :: [(a -> b)] -> ([(a -> b)] -> [c]) -> [c]
 *
 * @internal
 * @param array $patterns
 * @param callable $transformer
 * @return mixed
 */
function baseFilter(
  $default,
  array $patterns,
  callable $success,
  callable ...$filters
) {
  return filterMaybeN(
    $default,
    $patterns,
    $success,
    ...f\extend([
      f\partial('key_exists', '_'),
      f\partialRight(f\every, 'is_callable'),
    ], $filters)
  );
}

const filterMaybeN = __NAMESPACE__ . '\\filterMaybeN';

/**
 * filterMaybeN
 * performs Maybe monad case analysis with multiple filter predicates
 *
 * filterMaybeN :: b -> a -> (a -> b) -> [(a -> Bool)] -> b
 *
 * @internal
 * @param mixed $default
 * @param mixed $value
 * @param callable $success
 * @param callable ...$filters
 * @return mixed
 */
function filterMaybeN(
  $default,
  $value,
  callable $success,
  callable ...$filters
) {
  return Maybe\maybe(
    $default,
    $success,
    // apply multiple filters to Maybe type
    f\fold(function (Monad $maybe, callable $filter) {
      return $maybe->filter($filter);
    }, $filters, Maybe::just($value))
  );
}
