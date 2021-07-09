<?php

declare(strict_types=1);

/**
 * Immutable List interface
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

interface ImmutableList extends ImmutableDataStructure
{
  /**
   * map
   * transforms every entry in an immutable list in a single iteration
   *
   * map :: ImmutableList => l [a] -> (a -> b) -> l [b]
   *
   * @param callable $func
   * @return ImmutableList
   */
  public function map(callable $func): ImmutableList;

  /**
   * filter
   * selects list entries that conform to a boolean predicate
   *
   * filter :: ImmutableList => l [a] -> (a -> Bool) -> l [a]
   *
   * @param callable $func
   * @return ImmutableList
   */
  public function filter(callable $func): ImmutableList;

  /**
   * fold
   * transforms list into a single value
   *
   * fold :: ImmutableList => l [a] -> (a -> b -> c) -> a -> a
   *
   * @param callable $func
   * @param mixed $acc
   * @return mixed $acc
   */
  public function fold(callable $func, $acc);

  /**
   * flatMap
   * performs map operation and returns an array
   *
   * flatMap :: ImmutableList => l [a] -> (a -> b) -> [b]
   *
   * @param callable $func
   * @return array
   */
  public function flatMap(callable $func): array;

  /**
   * slice
   * removes elements from the front of a list structure
   *
   * slice :: ImmutableList => l [a] -> Int -> l [a]
   *
   * @param integer $count
   * @return ImmutableList
   */
  public function slice(int $count): ImmutableList;

  /**
   * merge
   * concatenates two immutable list structures
   *
   * merge :: ImmutableList => l [a] -> l [b] -> l [a, b]
   *
   * @param ImmutableList $list
   * @return ImmutableList
   */
  public function merge(ImmutableList $list): ImmutableList;

  /**
   * mergeN
   * concatenates multiple immutable lists
   *
   * mergeN :: ImmutableList => l [a] -> l [b] -> l [a, b]
   *
   * @param ImmutableList ...$lists
   * @return ImmutableList
   */
  public function mergeN(ImmutableList ...$lists): ImmutableList;

  /**
   * reverse
   * reverses the order of an immutable list
   *
   * reverse :: ImmutableList => l [a] -> l [a]
   *
   * @return ImmutableList
   */
  public function reverse(): ImmutableList;

  /**
   * fill
   * replaces values that correspond to indexes in specified range
   *
   * fill :: ImmutableList => l [a] -> b -> Int -> Int -> l [b]
   *
   * @param [type] $value
   * @param integer $start
   * @param integer $end
   * @return ImmutableList
   */
  public function fill($value, int $start, int $end): ImmutableList;

  /**
   * fetch
   * returns the value that corresponds to specified key
   *
   * fetch :: ImmutableList => l [a] -> b -> a
   *
   * @param mixed $key
   * @return ImmutableList
   */
  public function fetch($key): ImmutableList;

  /**
   * unique
   * purges list of duplicate values
   *
   * unique :: ImmutableList => l [a] -> l [a]
   *
   * @return ImmutableList
   */
  public function unique(): ImmutableList;

  /**
   * intersects
   * checks if two immutable lists intersect
   *
   * intersects :: ImmutableList => l [a] -> l [b] -> Bool
   *
   * @param ImmutableList $list
   * @return boolean
   */
  public function intersects(ImmutableList $list): bool;

  /**
   * implode
   * joins list elements with string
   *
   * implode :: ImmutableList => l [a] -> String -> String
   *
   * @param string $glue
   * @return string
   */
  public function implode(string $glue): string;

  /**
   * reject
   * selects list values that do not conform to boolean predicate
   *
   * reject :: ImmutableList => l [a] -> (a -> Bool) -> l [a]
   *
   * @param callable $func
   * @return ImmutableList
   */
  public function reject(callable $func): ImmutableList;

  /**
   * any
   * checks if at least one element in list conforms to boolean predicate
   *
   * any :: ImmutableList => l [a] -> (a -> Bool) -> Bool
   *
   * @param callable $func
   * @return boolean
   */
  public function any(callable $func): bool;

  /**
   * every
   * checks if each element in list conforms to boolean predicate
   *
   * every :: ImmutableList => l [a] -> (a -> Bool) -> Bool
   *
   * @param callable $func
   * @return boolean
   */
  public function every(callable $func): bool;
}
