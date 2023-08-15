<?php

/**
 * toPairs function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const toPairs = __NAMESPACE__ . '\\toPairs';

/**
 * toPairs
 * converts an associative array to one containing discrete pairs
 *
 * toPairs :: [a] -> [[a]]
 *
 * @param array $list
 * @return array
 * @example
 *
 * toPairs(['foo' => 'foo', 'bar' => '23'])
 * => [['foo', 'foo'], ['bar', '23']]
 */
function toPairs($list): array
{
  return fold(function ($acc, $val, $idx) {
    $acc[] = [$idx, $val];

    return $acc;
  }, $list, []);
}
