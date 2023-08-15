<?php

/**
 * cmatch
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

require_once __DIR__ . '/Internal/_ExecConsMatch.php';
require_once __DIR__ . '/Internal/_FilterMatch.php';

use function Chemem\Bingo\Functional\PatternMatching\Internal\_execConsMatch;
use function Chemem\Bingo\Functional\PatternMatching\Internal\_filterMatch;

/**
 * cmatch
 * selectively evaluates cons-evaluable data
 *
 * cmatch :: [([a] -> b)] -> [a] -> b
 *
 * @param array $patterns
 * @return callable
 * @example
 *
 * cmatch([
 *  '(x:_)' => fn ($x) => $x + 10,
 *  '_' => fn () => 0,
 * ])([2])
 * => 12
 */
function cmatch(array $patterns): callable
{
  // extract cons pattern counts
  $cons = _filterMatch($patterns);

  return function (array $values) use ($patterns, $cons) {
    // return false on invalid cons data
    // perform match otherwise
    return empty($cons) ?
      false :
      _execConsMatch($patterns, $cons, $values);
  };
}
