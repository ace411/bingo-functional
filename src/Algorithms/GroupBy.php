<?php

/**
 * groupBy function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const groupBy = __NAMESPACE__ . '\\groupBy';

/**
 * groupBy
 * sorts a multi-dimensional list by a specified key
 *
 * groupBy :: [a] -> b -> [a]
 * 
 * @param array $list
 * @param string|integer $key
 * @return array
 * @example
 * 
 * groupBy([
 *  ['pos' => 'sg', 'name' => 'jordan'],
 *  ['pos' => 'pg', 'name' => 'curry'],
 *  ['pos' => 'sg', 'name' => 'wade']
 * ], 'pos');
 * //=> [
 *  'sg' => [
 *    ['pos' => 'sg', 'name' => 'jordan'],
 *    ['pos' => 'sg', 'name' => 'wade']
 *  ],
 *  'pg' => [
 *    ['pos' => 'pg', 'name' => 'curry']
 *  ]
 * ]
 */
function groupBy(array $list, $key): array
{
  $groupFn = function (array $acc = []) use ($list, $key) {
    foreach ($list as $index => $value) {
      $acc[$value[$key]][] = isset($list[$index][$key]) ? $value : [];
    }

    return $acc;
  };

  return isArrayOf($list) == 'array' ? $groupFn() : $list;
}
