<?php

/**
 * _merge function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Fold.php';

const _merge = __NAMESPACE__ . '\\_merge';

/**
 * _merge
 * combines several lists into a single array
 *
 * _merge :: [a] -> [b] -> [a, b]
 *
 * @param array|object ...$lists
 * @return array
 */
function _merge(...$lists)
{
  return _fold(
    function ($acc, $list) {
      if (\is_object($list) || \is_iterable($list)) {
        foreach ($list as $key => $value) {
          if (\is_string($key)) {
            $acc[$key] = $value;
          } else {
            $acc[] = $value;
          }
        }
      }

      return $acc;
    },
    $lists,
    []
  );
}
