<?php

/**
 * Internal helper functions
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms\Internal;

use Chemem\Bingo\Functional\Algorithms as a;

/**
 * _count
 *
 * _count :: [a] -> Int
 *
 * @param mixed $list
 */
function _count($list)
{
  return \count(\is_array($list) ? $list : \get_object_vars($list));
}

const _count = __NAMESPACE__ . '\\count';

/**
 * _drop
 *
 * _drop :: [a, b] -> Int -> Bool -> [b]
 *
 * @param array $list
 * @param int $number
 * @param bool $left
 * @return array
 */
function _drop(
  array $list,
  int $number,
  bool $left = false
): array {
  $acc        = [];
  $count      = 0;
  $toIterate  = $left ? $list : \array_reverse($list);

  foreach ($toIterate as $idx => $val) {
    $count += 1;
    if ($count <= (\count($list) - $number)) {
      $acc[$idx] = $val;
    }
  }

  return $left ? $acc : \array_reverse($acc);
}

const _drop = __NAMESPACE__ . '\\_drop';

/**
 * _fold
 * template for fold operation
 *
 * _fold :: (a -> b -> c -> a) -> [b] -> a -> a
 *
 * @internal
 * @param callable $func
 * @param mixed $list
 * @param mixed $acc
 * @return mixed
 */
function _fold(callable $func, $list, $acc)
{
  if (\is_array($list) || \is_object($list)) {
    foreach ($list as $idx => $val) {
      $acc = $func($acc, $val, $idx);
    }
  }

  return $acc;
}

const _fold = __NAMESPACE__ . '\\_fold';

/**
 * _partial
 * template for partial* functions
 *
 * _partial :: (a -> b -> c) -> [a, b] -> Bool -> (a) b
 *
 * @internal
 * @param callable $func
 * @param array $args
 * @param bool $left
 * @return calllable
 */
function _partial(
  callable $func,
  array $args,
  bool $left = true
): callable {
  $argCount = (new \ReflectionFunction($func))
    ->getNumberOfRequiredParameters();

  $acc      = function (...$inner) use (&$acc, $func, $argCount, $left) {
    return function (...$innermost) use (
      $inner,
      $acc,
      $func,
      $left,
      $argCount
    ) {
      $final = $left ?
        a\extend($inner, $innermost) :
        a\extend(\array_reverse($innermost), \array_reverse($inner));

      if ($argCount <= \count($final)) {
        return $func(...$final);
      }

      return $acc(...$final);
    };
  };

  return $acc(...$args);
}

const _partial = __NAMESPACE__ . '\\_partial';

/**
 * _curryN
 * template for curryN* functions
 *
 * _curryN :: Int -> (a, (b)) -> Bool -> (b)
 *
 * @internal
 * @param int $argCount
 * @param callable $function
 * @param bool $left
 * @return callable
 */
function _curryN(
  int $argCount,
  callable $function,
  bool $left = true
): callable {
  $acc = function ($args) use ($argCount, $function, $left, &$acc) {
    return function (...$inner) use (
      $argCount,
      $function,
      $args,
      $left,
      $acc
    ) {
      $final = \array_merge($args, $inner);
      if ($argCount <= \count($final)) {
        return $function(...($left ? $final : \array_reverse($final)));
      }

      return $acc($final);
    };
  };


  return $acc([]);
}

const _curryN = __NAMESPACE__ . '\\_curryN';

/**
 * _curry
 * template for curry* functions
 * 
 * _curry :: ((a, b) -> c) -> (Int -> ((a, b) -> c) -> a -> b -> c) -> Bool -> a -> b -> c
 *
 * @internal
 * @param callable $func
 * @param callable $curry
 * @param boolean $required
 * @return callable
 */
function _curry(
  callable $func,
  callable $curry,
  $required = true
): callable {
  $toCurry = new \ReflectionFunction($func);

  $paramCount = $required ?
    $toCurry->getNumberOfRequiredParameters() :
    $toCurry->getNumberOfParameters();

  return $curry($paramCount, $func);
}

const _curry = __NAMESPACE__ . '\\_curry';
