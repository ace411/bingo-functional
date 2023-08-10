<?php

/**
 * _filterNumeric function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

const _filterNumeric = __NAMESPACE__ . '\\_filterNumeric';

/**
 * _filterNumeric
 * filter numeric input
 *
 * _filterNumeric :: a -> Int
 *
 * @internal
 * @param mixed $item
 * @return mixed
 */
function _filterNumeric($item)
{
  return \filter_var(
    $item,
    FILTER_VALIDATE_FLOAT |
    FILTER_VALIDATE_INT
  );
}
