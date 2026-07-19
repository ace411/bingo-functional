<?php

/**
 * _drop function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Fold.php';
require_once __DIR__ . '/_Props.php';
require_once __DIR__ . '/_Size.php';

const _drop = __NAMESPACE__ . '\\_drop';

/**
 * _drop
 * drops elements from either the front or back of the list
 *
 * _drop :: [a, b] -> Int -> Bool -> [b]
 *
 * @internal
 * @param object|array $list
 * @param int $number
 * @param bool $left
 * @return array
 */
function _drop($list, $count, $left = true)
{
  $idx = 0;

  if ($left) {
    foreach ($list as $key => $value) {
      if (++$idx <= $count) {
        if (\is_object($list)) {
          unset($list->{$key});
        } elseif (\is_array($list)) {
          unset($list[$key]);
        }
      } else {
        break;
      }
    }

    return $list;
  }

  $obj = \is_object($list);
  $tmp = $obj ?
    _props($list) :
    $list;

  \end($tmp);

  while ($idx < $count) {
    $key = \key($tmp);

    unset($tmp[$key]);

    $prev = \prev($tmp);

    if (!$prev) {
      \end($tmp);
    }

    $idx++;
  }

  return $obj ?
    _fold(
      function ($acc, $value, $key) {
        $acc->{$key} = $value;

        return $acc;
      },
      $tmp,
      (new \ReflectionClass($list))
        ->newInstanceWithoutConstructor()
    ) :
    $tmp;
}
