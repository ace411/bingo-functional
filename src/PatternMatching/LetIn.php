<?php

/**
 * letIn
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

use function Chemem\Bingo\Functional\fold;
use function FunctionalPHP\PatternMatching\extract;

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
 * => 4
 */
function letIn(string $pattern, array $items): callable
{
  // extract the tokens from the list
  $tokens = extract($pattern, $items);

  return function (array $keys, callable $func) use ($tokens) {
    return $func(
      ...(
        fold(
          function (array $acc, string $key) use ($tokens) {
            if (isset($tokens[$key])) {
              $acc[] = $tokens[$key];
            }

            return $acc;
          },
          $keys,
          []
        )
      )
    );
  };
}
