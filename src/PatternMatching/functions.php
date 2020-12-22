<?php

/**
 * Pattern matching functions.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

use Chemem\Bingo\Functional\Algorithms as A;
use Chemem\Bingo\Functional\Functors\Maybe;
use FunctionalPHP\PatternMatching as p;

const match = __NAMESPACE__ . '\\match';

/**
 * match
 * selectively evaluates cons-evaluable data
 *
 * match :: [([a] -> b)] -> [a] -> b
 * 
 * @param array $options
 * @return callable
 * @example
 * 
 * match([
 *  '(x:_)' => fn ($x) => $x + 10,
 *  '_' => fn () => 0,
 * ])([2])
 * //=> 12
 */
function match(array $options): callable
{
  $matchFn = function (array $options): array {
    return \array_key_exists('_', $options) ?
      $options :
      [
        '_' => function () {
          return false;
        },
      ];
  };

  $conditionGen = A\compose(
    $matchFn,
    A\partialRight('array_filter', function ($value) {
      return \is_callable($value);
    }),
    'array_keys',
    getNumConditions
  );

  return function (array $values) use ($options, $matchFn, $conditionGen) {
    $valCount = \count($values);

    $check = A\compose(
      $conditionGen,
      A\partialLeft(A\filter, function (int $count) use ($valCount) {
        return $count == $valCount;
      }),
      A\head
    );

    return $check($options) > 0 ?
      \call_user_func_array(
        $options[A\indexOf($conditionGen($options), $valCount)],
        $values
      ) :
      \call_user_func($matchFn($options)['_']);
  };
}

const getNumConditions = __NAMESPACE__ . '\\getNumConditions';

/**
 * getNumConditions
 * computes the number of conditions relative to the cons count
 *
 * @internal
 * @param array $conditions
 * @return array
 */
function getNumConditions(array $conditions)
{
  $checkOpt = function (string $opt): string {
    return \preg_match('/([_])+/', $opt) ? $opt : '_';
  };

  $extr = A\map(
    function (string $condition) use ($checkOpt) {
      $opts = A\compose(
        $checkOpt,
        A\partialLeft('preg_replace', '/([(\)])+/', ''),
        A\partialLeft('explode', ':'),
        A\partialLeft(A\filter, function ($val) {
          return $val !== '_';
        }),
        'count'
      );

      return [$condition => $opts($condition)];
    },
    $conditions
  );

  return \array_merge(...$extr);
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
  $matches = Maybe\Maybe::just($value)
    ->filter(function ($value) {
      return !empty($value) || !isset($value);
    });

  return Maybe\maybe(
    \key_exists('_', $patterns) ? ($patterns['_'])() : false,
     function ($value) use ($patterns) {
       switch ($value) {
         case \is_object($value):
           return evalObjectPattern($patterns, $value);
           break;

         case \is_array($value):
           return evalArrayPattern($patterns, $value);
           break;

         case \is_string($value):
           return evalStringPattern($patterns, $value);
           break;
        }
     },
     $matches
  );
}


const evalArrayPattern = __NAMESPACE__ . '\\evalArrayPattern';

/**
 * evalArrayPattern
 * selectively evaluates patterns that manifest in arrays
 *
 * evalArrayPattern :: [a, b] -> [a] -> (a())
 *
 * @internal
 * @param array $patterns
 * @param array $value
 * @return mixed $result
 */
function evalArrayPattern(array $patterns, array $comp)
{
  return p\match($patterns, $comp);
}

const evalStringPattern = __NAMESPACE__ . '\\evalStringPattern';

/**
 * evalStringPattern
 * selectively evaluates patterns that manifest in strings
 *
 * evalStringPattern :: [a, b] -> a -> (a())
 *
 * @internal
 * @param array $patterns
 * @param string $value
 * @return mixed
 */
function evalStringPattern(array $patterns, string $value)
{
  $evalPattern = A\compose(
    'array_keys',
    A\partialLeft(A\filter, function ($val) {
      return \is_string($val) && \preg_match('/([\"]+)/', $val);
    }),
    A\partialLeft(
      A\map,
      function ($val) use ($value) {
        $evaluate = A\compose(
          A\partialLeft('str_replace', '"', ''),
          function ($val) {
            $valType = \gettype($val);

            return $valType == 'integer' ?
              (int) $val :
              ($valType == 'double' ? (float) $val : $val);
          },
          function ($val) use ($value) {
            if (empty($value)) {
              return '_';
            }
                    
            return $val == $value ? A\concat('"', '', $val, '') : '_';
          }
        );

        return $evaluate($val);
      }
    ),
    A\partialLeft(A\filter, function ($val) {
      return $val !== '_';
    }),
    function ($match) {
      return !empty($match) ? A\head($match) : '_';
    },
    function ($match) use ($patterns) {
      $valType = A\compose('array_values', A\isArrayOf)($patterns);

      return $valType == 'object' ?
        $patterns[$match] :
        ['_' => A\constantFunction(false)];
    }
    )($patterns);

  return \call_user_func($evalPattern);
}

const evalObjectPattern = __NAMESPACE__ . '\\evalObjectPattern';

/**
 * evalObjectPattern
 * selectively evaluates patterns that manifest in objects
 *
 * evalObjectPattern :: [a, b] -> b -> (b())
 *
 * @internal
 * @param array $patterns
 * @param object $value
 * @return mixed
 */
function evalObjectPattern(array $patterns, $value)
{
  $valObj = \get_class($value);

  $eval = A\compose(
    'array_keys',
    A\partialLeft(A\filter, function ($val) {
      return \is_string($val) && \preg_match('/([a-zA-Z]+)/', $val);
    }),
    A\partialLeft(A\filter, function ($classStr) use ($valObj) {
      return \class_exists($classStr) && $classStr == $valObj;
    }),
    A\head,
    function (string $match) {
      return !empty($match) && !\is_null($match) ? A\identity($match) : A\identity('_');
    },
    function (string $key) use ($patterns) {
      $func = $key == '_' ? isset($patterns['_']) ? A\identity($patterns['_']) : constantFunction(false) : A\identity($patterns[$key]);

      return \call_user_func($func);
    }
  );

  return $eval($patterns);
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
 * letIn('[a, b, _]', range(1, 3))(
 *  'b',
 *  fn ($x) => $x ** 2,
 * )
 * //=> 4
 */
function letIn(string $pattern, array $items): callable
{
  // extract the tokens from the list
  $tokens = p\extract($pattern, $items);

  return function (array $keys, callable $func) use ($tokens) {
    // match keys against extracted tokens
    $args = A\fold(function (array $acc, string $key) use ($tokens) {
      if (isset($tokens[$key])) {
        $acc[] = $tokens[$key];
      }

      return $acc;
    }, $keys, []);

    return $func(...$args);
  };
}
