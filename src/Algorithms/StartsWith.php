<?php

/**
 * startsWith function
 *
 * startsWith :: String -> String -> bool
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const startsWith = __NAMESPACE__ . '\\startsWith';

function startsWith(string $haystack, string $needle): bool
{
  $strLen = \mb_strlen($needle, 'utf-8');

  return \substr($haystack, 0, $strLen) === $needle;
}
