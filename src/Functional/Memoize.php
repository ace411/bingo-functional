<?php

/**
 * memoize function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

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
 * $fact = function ($x) use (&$fact) {
 *  return $x < 2 ? 1 : $x * $fact($x - 1);
 * };
 * memoize($fact)(5);
 * => 120
 */
function memoize(callable $function, bool $apc = false): callable
{
  return function (...$args) use ($apc, $function) {
    static $cache = [];
    $key          = \md5(
      \extension_loaded('igbinary') ?
        \igbinary_serialize($args) :
        \serialize($args)
    );

    if ($apc && \extension_loaded('apcu')) {
      \apcu_add($key, $function(...$args));

      return \apcu_exists($key) ? \apcu_fetch($key) : $function(...$args);
    }

    if (!isset($cache[$key])) {
      $cache[$key] = $function(...$args);
    }

    return $cache[$key] ?? $function(...$args);
  };
}
