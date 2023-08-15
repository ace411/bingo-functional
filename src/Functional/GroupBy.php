<?php

/**
 * groupBy function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

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
 * => [
 *  'sg' => [
 *    ['pos' => 'sg', 'name' => 'jordan'],
 *    ['pos' => 'sg', 'name' => 'wade']
 *  ],
 *  'pg' => [
 *    ['pos' => 'pg', 'name' => 'curry']
 *  ]
 * ]
 */
function groupBy($list, $key): array
{
  return fold(
    function ($acc, $val, $idx) use ($list, $key) {
      $acc[$val[$key]][] = isset($list[$idx][$key]) ? $val : [];

      return $acc;
    },
    $list,
    []
  );
}
