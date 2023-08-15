<?php

/**
 * _mergeN function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Fold.php';

const _mergeN = __NAMESPACE__ . '\\_mergeN';

/**
 * _mergeN
 * recursively combines several lists into a single array
 *
 * _mergeN :: [a] -> [b] -> [a, b]
 *
 * @param array|object ...$lists
 * @return array
 */
function _mergeN(...$lists)
{
  return _fold(
    function ($acc, $list) {
      if (\is_object($list) || \is_iterable($list)) {
        foreach ($list as $key => $value) {
          if (\is_object($value) || \is_iterable($value)) {
            $acc[$key] = _mergeN($acc[$key] ?? null, $value);
          } else {
            if (\is_string($key)) {
              $acc[$key] = $value;
            } else {
              if (isset($acc[$key])) {
                $acc[] = $value;
              } else {
                $acc[$key] = $value;
              }
            }
          }
        }
      }

      return $acc;
    },
    $lists,
    []
  );
}
