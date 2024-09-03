<?php

/**
 * _type function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching\Parser;

const _type = __NAMESPACE__ . '\\_type';

/**
 * _type
 * aptly tokenizes parsable lexical sequences
 *
 * _type :: String -> Array
 *
 * @param string $input
 * @return iterable
 */
function _type(string $input): iterable
{
  if (\preg_match('/^(\[){1}(.*)(\]){1}$/ix', $input, $matches)) {
    $patterns = isset($matches[2]) ? $matches[2] : '_';

    return _tokenize($patterns, PM_RULE_ARRAY);
  }

  if (\preg_match('/^(\(){1}(.*)(\:\_)?(\)){1}$/ix', $input, $matches)) {
    $patterns = isset($matches[2]) ? $matches[2] : '_';

    return _tokenize($patterns, PM_RULE_CONS);
  }

  if (\preg_match('/^(\_)$/ix', $input)) {
    return _tokenize($input, PM_RULE_WILDCARD);
  }

  if (\preg_match('/(\"(\\\\.|[^\"])*\")/ix', $input)) {
    return _tokenize($input, PM_RULE_STRING);
  }

  return _tokenize($input, PM_RULE_IDENTIFIER);
}
