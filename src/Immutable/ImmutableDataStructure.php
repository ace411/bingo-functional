<?php

declare(strict_types=1);

/**
 * ImmutableDataStructure interface
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

interface ImmutableDataStructure
{
  /**
   * from
   * creates an immutable structure from a hashtable
   *
   * from :: [a] -> ImmutableDS [a]
   *
   * @param mixed $array
   * @return ImmutableDataStructure
   */
  public static function from(array $list): ImmutableDataStructure;

  /**
   * contains
   * checks if a value exists in an immutable structure
   *
   * contains :: ImmutableDS => l [a] -> a -> Bool
   *
   * @param mixed $element
   * @return boolean
   */
  public function contains($element): bool;

  /**
   * head
   * outputs first element in immutable structure
   *
   * head :: ImmutableDS => l [a] -> a
   *
   * @return mixed
   */
  public function head();

  /**
   * tail
   * extracts elements after the head of the structure
   *
   * tail :: ImmutableDS => l [a] -> l [a]
   *
   * @return ImmutableDataStructure
   */
  public function tail(): ImmutableDataStructure;

  /**
   * last
   * outputs the last element in the structure
   *
   * last :: ImmutableDS => l [a] -> a
   *
   * @return mixed
   */
  public function last();
}
