<?php

/**
 * min function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_FilterNumeric.php';

use function Chemem\Bingo\Functional\Internal\_filterNumeric;

const min = __NAMESPACE__ . '\\min';

/**
 * min
 * computes the lowest value in a collection
 *
 * min :: [a] -> Int
 *
 * @param array|object $list
 * @return int|float
 * @example
 *
 * min((object) [12, 4, 6, 99, 3])
 * => 3
 */
function min($list)
{
  // extract first element in list
  $fst = head($list);

  return fold(
    function ($acc, $val) {
      return _filterNumeric($val) ? ($val < $acc ? $val : $acc) : $acc;
    },
    $list,
    !_filterNumeric($fst) ? 0 : $fst
  );
}
