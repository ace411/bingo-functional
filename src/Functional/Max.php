<?php

/**
 * max function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_FilterNumeric.php';

use function Chemem\Bingo\Functional\Internal\_filterNumeric;

const max = __NAMESPACE__ . '\\max';

/**
 * max
 * computes the largest number in a collection
 *
 * max :: [a] -> Int
 *
 * @param array|object $list
 * @return int|float
 * @example
 *
 * max((object) [12, 4, 6, 99, 3])
 * => 99
 */
function max($list)
{
  return fold(
    function ($acc, $val) {
      // ensure comparisons between numeric types
      return _filterNumeric($val) ? ($val > $acc ? $val : $acc) : $acc;
    },
    $list,
    0
  );
}
