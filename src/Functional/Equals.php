<?php

/**
 * equals function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_RefObj.php';

use function Chemem\Bingo\Functional\Internal\_refobj;

const equals = __NAMESPACE__ . '\\equals';

/**
 * equals
 * perform artifact comparisons to ascertain equivalence
 *
 * equals :: a -> b -> Bool -> Bool
 *
 * @param mixed $fst
 * @param mixed $snd
 * @param boolean $recurse
 * @return boolean
 * @example
 *
 * equals((object)range(1, 5), (object)range(2, 4));
 * => false
 */
function equals($fst, $snd, bool $recurse = false): bool
{
  $ft   = \gettype($fst);
  $st   = \gettype($snd);
  // store core types in list to preempt redeclaration
  $core = [
    'integer',
    'string',
    'boolean',
    'array',
    'double',
    'NULL',
  ];

  if ($ft !== $st) {
    return false;
  }

  if (\in_array($ft, $core) && \in_array($st, $core)) {
    return $fst === $snd;
  }

  if ($ft === 'resource' && $st === 'resource') {
    return \get_resource_type($fst) === \get_resource_type($snd);
  }

  if ($ft === 'object' && $st === 'object') {
    return _refobj($fst, $recurse) === _refobj($snd, $recurse);
  }

  return false;
}
