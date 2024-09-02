<?php

/**
 * _tokenize function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching\Parser;

use function Chemem\Bingo\Functional\equals;

const _tokenize = __NAMESPACE__ . '\\_tokenize';

/**
 * _tokenize
 * tokenizes pattern input in accordance with crystalized pattern-matching grammar
 *
 * _tokenize :: String -> Int -> Array
 *
 * @param string $input
 * @param int $type
 * @return iterable
 */
function _tokenize(string $input, int $type): iterable
{
  if (
    !\in_array(
      $type,
      [
        PM_RULE_CONS,
        PM_RULE_WILDCARD,
        PM_RULE_ARRAY,
        PM_RULE_UNKNOWN,
        PM_RULE_IDENTIFIER,
        PM_RULE_STRING,
      ]
    )
  ) {
    return [];
  }

  $acc  = [];
  $tc   = 0;

  if (equals($type, PM_RULE_ARRAY)) {
    foreach (\preg_split('/(\s)?\,(\s)?/ix', $input) as $idx => $token) {
      if (!empty($token)) {
        $result = _tag($token, $tc);

        if (\preg_match('/^(\(){1}(.*)(\:\_)?(\)){1}$/ix', $result[1], $matches)) {
          $patterns  = isset($matches[2]) ?
            \str_replace(['(', ')'], '', $matches[2]) :
            [];

          $acc[$idx] = \array_merge(
            $acc[$idx] ?? [],
            [PM_CONS, _tokenize($patterns, PM_RULE_CONS)['tokens']]
          );
        } else {
          $acc[$idx] = $result;
        }
      }
    }
  } elseif (equals($type, PM_RULE_CONS)) {
    foreach (\preg_split('/(\s)?\:(\s)?/ix', $input) as $token) {
      if (!empty($token)) {
        $acc[] = _tag($token, $tc);
      }
    }
  } else {
    $acc[] = _tag($input, $tc);
  }

  return [
    'tokens'       => $acc,
    'token_count'  => $tc,
    'type'         => $type,
  ];
}
