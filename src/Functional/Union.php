<?php

/**
 * union function
 *
 * @see https://lodash.com/docs/4.17.11#union
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const union = __NAMESPACE__ . '\\union';

/**
 * union
 * combines multiple arrays into a single list of unique elements
 *
 * union :: [a] -> [b] -> [a, b]
 *
 * @param array|object ...$values
 * @return array
 * @example
 *
 * union(range(1, 3), range(2, 5))
 * => [1, 2, 3, 4, 5]
 */
function union(...$values)
{
  return compose(flatten, unique)($values);
}
