<?php

/**
 * _size function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Fold.php';

const _size = __NAMESPACE__ . '\\_size';

/**
 * _size
 * compute the size of a list
 *
 * _size :: [a] -> Int
 *
 * @param array|object $list
 * @return int
 */
function _size($list): int
{
  return !\is_countable($list) ?
    (
      \is_object($list) ?
        _fold(
          function (int $size) {
            $size += 1;

            return $size;
          },
          $list,
          0
        ) :
        0
    ) :
    \count($list);
}
