<?php

/**
 * extend function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Merge.php';

use function Chemem\Bingo\Functional\Internal\_merge;

const extend = __NAMESPACE__ . '\\extend';

/**
 * extend
 * concatenates lists
 *
 * @param object|array ...$lists
 * @return array
 * @example
 *
 * extend(['foo', 'bar'], (object) ['baz'], ['fooz'])
 * => ['foo', 'bar', 'baz', 'fooz']
 */
function extend(...$lists)
{
  return _merge(...$lists);
}
