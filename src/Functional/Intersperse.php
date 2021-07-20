<?php

declare(strict_types=1);

/**
 * intersperse function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const intersperse = __NAMESPACE__ . '\\intersperse';

/**
 * intersperse
 * creates a list with an arbitrary value interposed between elements
 *
 * intersperse :: b -> [a] -> [a, b]
 *
 * @param mixed $element
 * @param array $list
 * @return array
 * @example
 *
 * intersperse('foo', range(1, 3));
 * => [1, 'foo', 2, 'foo', 3]
 */
function intersperse($element, array $list): array
{
  $elem = \array_pad([], \count($list), $element);
  $res  = \array_merge(...\array_map(null, $list, $elem));

  return dropRight($res, 1);
}
