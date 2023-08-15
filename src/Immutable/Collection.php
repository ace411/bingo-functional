<?php

/**
 * Immutable ImmutableList class.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Common\Traits\TransientMutator as Transient;
use Ds\Vector;

class Collection implements
  \JsonSerializable,
  \IteratorAggregate,
  \Countable,
  ImmutableList
{
  use CommonTrait;
  use Transient;

  /**
   * {@inheritdoc}
   */
  public function map(callable $func): ImmutableList
  {
    $count  = $this->count();
    $list   = \extension_loaded('ds') ?
      new Vector() :
      new \SplFixedArray($count);

    if ($this->list instanceof \SplFixedArray) {
      for ($idx = 0; $idx < $count; $idx++) {
        $list[$idx] = $func($this->getList()[$idx]);
      }
    } else {
      $list = $list->merge($this->getList()->map($func));
    }

    return new static($list);
  }

  /**
   * {@inheritdoc}
   */
  public function flatMap(callable $func): array
  {
    // \trigger_error('Please call map instead', E_USER_DEPRECATED);

    return $this->map($func)->toArray();
  }

  /**
   * {@inheritdoc}
   */
  public function filter(callable $func): ImmutableList
  {
    return $this->filterOperation($func);
  }

  /**
   * {@inheritdoc}
   */
  public function fold(callable $func, $acc)
  {
    $list = $this->getList();

    if ($list instanceof \SplFixedArray) {
      for ($idx = 0; $idx < $list->count(); $idx++) {
        $acc = $func($acc, $list[$idx]);
      }

      return $acc;
    }

    return $list->reduce($func, $acc);
  }

  /**
   * {@inheritdoc}
   */
  public function slice(int $count): ImmutableList
  {
    $new = null;

    if (\extension_loaded('ds')) {
      $new = $this
        ->getList()
        ->slice($count);
    } else {
      $list       = $this->getList();
      $listCount  = $list->count();
      $new        = new \SplFixedArray($listCount - $count);

      for ($idx = 0; $idx < $new->count(); $idx++) {
        $new[$idx] = $list[$idx + $count];
      }
    }

    return new static($new);
  }

  /**
   * {@inheritdoc}
   */
  public function merge(ImmutableList $list): ImmutableList
  {
    $oldSize        = $this->getSize();
    $combinedSize   = $oldSize + $list->getSize();
    $old            = $this->list;

    if ($old instanceof \SplFixedArray) {
      $old->setSize($combinedSize);

      for ($idx = 0; $idx < $old->count(); $idx++) {
        if ($idx > ($oldSize - 1)) {
          $old[$idx] = $list->getList()[($idx - $oldSize)];
        }
      }

      return $this->update($old);
    }

    return $this->update($old->merge($list));
  }

  /**
   * {@inheritdoc}
   */
  public function mergeN(ImmutableList ...$lists): ImmutableList
  {
    return $this->merge(
      \array_shift($lists)
        ->triggerMutation(function ($list) use ($lists) {
          for ($idx = 0; $idx < \count($lists); $idx++) {
            $list->merge($lists[$idx]);
          }

          return $list;
        })
    );
  }

  /**
   * {@inheritdoc}
   */
  public function reverse(): ImmutableList
  {
    $list   = $this->getList();

    if (\extension_loaded('ds')) {
      $list->reverse();

      return new static($list);
    }

    $count  = $list->count();
    $new    = new \SplFixedArray($count);

    for ($idx = 0; $idx < $count; $idx++) {
      $new[$idx] = $list[($count - $idx - 1)];
    }

    return new static($new);
  }

  /**
   * {@inheritdoc}
   */
  public function fill($value, int $start, int $end): ImmutableList
  {
    $list = $this->getList();

    for ($idx = 0; $idx < $list->count(); $idx++) {
      $list[$idx] = $idx >= $start && $idx <= $end ?
        $value :
        $list[$idx];
    }

    return new static($list);
  }

  /**
   * {@inheritdoc}
   */
  public function fetch($key): ImmutableList
  {
    $list = $this->getList();
    $extr = [];

    for ($idx = 0; $idx < $list->count(); $idx++) {
      $item = $list[$idx];

      if (\is_array($item) && \key_exists($key, $item)) {
        $extr[] = $item[$key];
      }
    }

    return self::from($extr);
  }

  /**
   * {@inheritdoc}
   */
  public function unique(): ImmutableList
  {
    $list   = $this->getList();
    $acc    = [];

    for ($idx = 0; $idx < $list->count(); $idx++) {
      $item = $list[$idx];
      if (!\in_array($item, $acc)) {
        $acc[] = $item;
      }
    }

    return self::from($acc);
  }

  /**
   * {@inheritdoc}
   */
  public function intersects(ImmutableList $list): bool
  {
    $intersect  = false;
    $main       = $this->getSize();
    $oth        = $list->getSize();

    if ($main > $oth) {
      for ($idx = 0; $idx < $oth; $idx++) {
        if (\in_array($list->getList()[$idx], $this->toArray())) {
          $intersect = true;
        }

        if (f\equals($intersect, true)) {
          break;
        }
      }
    } elseif ($oth > $main) {
      for ($idx = 0; $idx < $main; $idx++) {
        if (\in_array($this->getList()[$idx], $list->toArray())) {
          $intersect = true;
        }

        if (f\equals($intersect, true)) {
          break;
        }
      }
    }

    return $intersect;
  }

  /**
   * {@inheritdoc}
   */
  public function implode(string $delimiter): string
  {
    return \rtrim($this->fold(function (string $fold, $elem) use ($delimiter) {
      $fold .= f\concat($delimiter, $elem, '');

      return $fold;
    }, ''), $delimiter);
  }

  /**
   * {@inheritdoc}
   */
  public function reject(callable $func): ImmutableList
  {
    return $this->filterOperation($func, false);
  }

  /**
   * {@inheritdoc}
   */
  public function any(callable $func): bool
  {
    $list   = $this->getList();
    $size   = $list->count();
    $result = false;

    for ($idx = 0; $idx < $size; $idx += 1) {
      if ($func($list[$idx])) {
        $result = true;

        break;
      }
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function every(callable $func): bool
  {
    return f\equals($this->reject($func)->getSize(), 0);
  }

  /**
   * @see ArrayIterator
   * {@inheritDoc}
   */
  public function offsetGet(int $offset)
  {
    if (!isset($this->list[$offset])) {
      throw new \OutOfRangeException('Offset does not exist');
    }

    return $this->list[$offset];
  }

  /**
   * getList
   * unwraps collection - revealing list inside of it
   *
   * getList :: Collection => c [a] -> [a]
   *
   * @return SplFixedArray|Vector $list
   */
  public function getList()
  {
    return $this->list;
  }

  /**
   * @see JsonSerializable
   * {@inheritDoc}
   */
  public function jsonSerialize()
  {
    return $this->list;
  }

  /**
   * getSize
   * returns list size
   *
   * getSize :: Collection => c [a] -> Int
   *
   * @return int
   */
  public function getSize(): int
  {
    return $this->count();
  }

  /**
   * toArray
   * @see ArrayIterator
   * {@inheritDoc}
   */
  public function toArray(): array
  {
    return $this->list->toArray();
  }

  /**
   * @see ArrayIterator
   * {@inheritDoc}
   */
  public function getIterator(): \ArrayIterator
  {
    return new \ArrayIterator($this->toArray());
  }

  /**
   * {@inheritdoc}
   */
  private function update($list)
  {
    if ($this->isMutable()) {
      $this->list = $list;

      return $this;
    }

    return new static($list);
  }

  /**
   * filterOperation function
   *
   * filterOperation :: (a -> Bool) -> Bool -> ImmutableList
   *
   * @access private
   * @internal template for filtration operations
   * @param callable $func
   * @param bool $pos
   */
  private function filterOperation(callable $func, bool $pos = true): ImmutableList
  {
    $list   = $this->getList();
    $count  = $list->count();
    $init   = 0;
    $new    = \extension_loaded('ds') ?
      new Vector() :
      new \SplFixedArray($list->count());

    for ($idx = 0; $idx < $count; $idx++) {
      if ($pos ? $func($list[$idx]) : !$func($list[$idx])) {
        if ($list instanceof \SplFixedArray) {
          $new[$init++] = $list[$idx];
        } else {
          $new[] = $list[$idx];
        }
      }
    }

    if ($list instanceof \SplFixedArray) {
      $new->setSize($init);
    }

    return new static($new);
  }
}
