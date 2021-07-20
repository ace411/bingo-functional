<?php

/**
 * toException function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const toException = __NAMESPACE__ . '\\toException';

/**
 * toException
 * enables anomalous situation handling via function application
 *
 * toException :: (a -> b) -> (Throwable -> c) -> b
 *
 * @param callable $func
 * @param callable $handler
 * @return callable
 * @example
 *
 * toException(function ($x, $y) {
 *  if ($y == 0) {
 *    throw new Exception('division by zero error');
 *  }
 *  return $x / $y;
 * }, fn ($_) => INF)(3, 0)
 * => INF
 */
function toException(callable $func, callable $handler = null): callable
{
  return function (...$args) use ($func, $handler) {
    try {
      return $func(...$args);
    } catch (\Throwable $exception) {
      return isset($handler) ?
        $handler($exception) :
        $exception->getMessage();
    } finally {
      \restore_error_handler();
    }
  };
}
