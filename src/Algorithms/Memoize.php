<?php

/**
 * memoize function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const memoize = __NAMESPACE__ . '\\memoize';

/**
 * memoize
 * caches function calls
 *
 * memoize :: (a -> b) -> a -> b
 *
 * @param callable $function
 * @return callable
 * @example
 *
 * $fact = memoize(function ($x) use (&$fact) {
 *  return $x < 2 ? 1 : $x * $fact($x - 1);
 * })(5);
 * //=> 120
 */
function memoize(callable $function): callable
{
  return function (...$args) use ($function) {
    static $cache = [];
    $key          = \md5(\serialize($args));
    // store result in variable to preempt re-computation
    $result       = $function(...$args);

    // store the result in the apcu cache if the extension is present
    if (\extension_loaded('apcu')) {
      \apcu_add($key, $result);
    }

    $cache[$key] = $result;

    return !\extension_loaded('apcu') ?
      // return cached result if it exists; pre-computed result otherwise
      (isset($cache[$key]) ? $cache[$key] : $result) :
      (\apcu_exists($key) ? \apcu_fetch($key) : $result);
  };
}
