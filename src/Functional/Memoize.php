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
function memoize(callable $function, bool $apc = false)
{
  return new class ($function, $apc) {
    private $function;
    private $apc;

    public function __construct(callable $function, bool $apc)
    {
      $this->function = $function;
      $this->apc      = $apc;
    }

    public function __invoke(...$args)
    {
      $key = \md5(
        \extension_loaded('igbinary') ?
          \igbinary_serialize($args) :
          \serialize($args)
      );

      if ($this->apc && \extension_loaded('apcu')) {
        $result = \apcu_fetch($key, $exists);

        if ($exists) {
          return $result;
        }

        $ret = ($this->function)(...$args);
        \apcu_store($key, $ret);

        return $ret;
      }

      if (isset($GLOBALS[$key])) {
        return $GLOBALS[$key];
      }

      $GLOBALS[$key] = ($this->function)(...$args);

      return $GLOBALS[$key];
    }
  };
}
