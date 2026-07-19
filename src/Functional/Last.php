<?php

/**
 * last function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Props.php';

use function Chemem\Bingo\Functional\Internal\_props;

const last = __NAMESPACE__ . '\\last';

/**
 * last
 * Outputs the last element in a list
 *
 * last :: [a] -> a -> a
 *
 * @param object|array $list
 * @return mixed
 * @example
 *
 * last(range(4, 7))
 * => 7
 */
function last($list, $default = null)
{
  if (
    !(
      \is_object($list) ||
      \is_array($list)
    )
  ) {
    return $default;
  }

  $data = \is_object($list) ?
    _props($list) :
    $list;

  \end($data);

  $result = \current($data);
  $key    = \key($data);

  return isset($key) ?
    $result :
    $default;
}
