<?php

/**
 * head function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Props.php';

use function Chemem\Bingo\Functional\Internal\_props;

const head = __NAMESPACE__ . '\\head';

/**
 * head
 * Outputs the first element in a list
 *
 * head :: [a] -> a -> a
 *
 * @param object|array $list
 * @param mixed $default
 * @return mixed
 * @example
 *
 * head(range(4, 7))
 * => 4
 */
function head($list, $default = null)
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

  \reset($data);

  $result = \current($data);
  $key    = \key($data);

  return isset($key) ?
    $result :
    $default;
}
