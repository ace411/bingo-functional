<?php

/**
 * _tag function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching\Parser;

const _tag = __NAMESPACE__ . '\\_tag';

/**
 * _tag
 * labels lexical unit post-tokenization
 *
 * _tag :: String -> Int -> Array
 *
 * @param string $input
 * @param int &$token
 * @return iterable
 */
function _tag(string $input, int &$token = 0): iterable
{
  $token++;

  if (\preg_match('/^(true)$/ix', $input)) {
    return [PM_TRUE, true];
  }

  if (\preg_match('/^(false)$/ix', $input)) {
    return [PM_FALSE, false];
  }

  if (\preg_match('/^(\-?\d+)$/', $input)) {
    return [PM_INTEGER, (int) $input];
  }

  if (\preg_match('/^(\-?\d+(\.\d+)?)$/', $input)) {
    return [PM_FLOAT, (float) $input];
  }

  if (\preg_match('/(\"(\\\\.|[^\"])*\")/ix', $input)) {
    return [
      PM_STRING,
      (
        \extension_loaded('mbstring') ?
          '\mb_substr' :
          '\substr'
      )($input, 1, -1)
    ];
  }

  if (\preg_match('/^(\_)$/ix', $input)) {
    return [PM_WILDCARD, $input];
  }

  return [PM_IDENTIFIER, $input];
}
