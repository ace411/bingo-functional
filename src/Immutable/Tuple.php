<?php

declare(strict_types=1);

/**
 * Immutable Tuple class
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

use function Chemem\Bingo\Functional\equals;

class Tuple implements \Countable, ImmutableDataStructure
{
  use CommonTrait;

  /**
   * fst
   * extracts the first component of a pair
   *
   * fst :: Tuple => Pair a b -> a
   *
   * @return mixed
   */
  public function fst()
  {
    if (!equals($this->count(), 2)) {
      throw new TupleException(TupleException::PAIR_ERRMSG);
    }

    if ($this->list instanceof \SplFixedArray) {
      $iterator = $this->list->getIterator();
      $iterator->rewind();

      return $iterator->current();
    }

    return $this->list->first();
  }

  /**
   * snd
   * extracts the second component of a pair
   *
   * snd :: Tuple => Pair a b -> b
   *
   * @return mixed
   */
  public function snd()
  {
    if (!equals($this->count(), 2)) {
      throw new TupleException(TupleException::PAIR_ERRMSG);
    }

    if ($this->list instanceof \SplFixedArray) {
      $iterator = $this->list->getIterator();
      $iterator->rewind();
      $idx = 0;
      while ($iterator->valid()) {
        if (equals($idx, 1)) {
          break;
        }

        $idx++;
        $iterator->next();
      }

      return $iterator->current();
    }

    return $this->list->last();
  }

  /**
   * swap
   * swaps the components of a pair
   *
   * swap :: Tuple => Pair a b -> Pair b a
   *
   * @return Tuple
   */
  public function swap(): Tuple
  {
    if ($this->count() != 2) {
      throw new TupleException(TupleException::PAIR_ERRMSG);
    }

    return self::from([$this->snd(), $this->fst()]);
  }

  /**
   * get
   * returns item that matches specified index
   *
   * get :: Tuple => t [a] -> Int -> a
   *
   * @param int $index
   * @return mixed
   */
  public function get(int $index)
  {
    return $this->offsetGet($index);
  }
}
