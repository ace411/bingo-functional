<?php

/**
 * reduceRight
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const reduceRight = __NAMESPACE__ . '\\reduceRight';

/**
 * alias of foldRight
 * @see foldRight
 */
function reduceRight(callable $func, $list, $acc)
{
  return foldRight($func, $list, $acc);
}
