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
    $list = $this->getList();
    $acc  = [];

    if ($list instanceof \SplFixedArray) {
      $iterator = $list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        $current = $iterator->current();
        $acc[]   = $func($current);

        $iterator->next();
      }
    } else {
      $idx = 0;
      while (isset($list[$idx])) {
        $current  = $list[$idx];
        $acc[]    = $func($current);

        $idx++;
      }
    }

    return self::from($acc);
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
      $iterator = $list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        $current  = $iterator->current();
        $acc      = $func($acc, $current);

        $iterator->next();
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
    $sliced = [];
    $list   = $this->getList();

    if ($list instanceof \SplFixedArray) {
      $iterator = $list->getIterator();
      $idx      = 0;
      $iterator->rewind();

      while ($iterator->valid()) {
        $includable = $iterator->key() + $count;

        if (isset($list[$includable])) {
          $sliced[] = $list[$includable];
        } else {
          break;
        }

        $idx++;
        $iterator->next();
      }

      return self::from($sliced);
    } else {
      return new static($list->slice($count));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function merge(ImmutableList $list): ImmutableList
  {
    $acc  = [];
    $acc  = f\extend($this->toArray(), $list->toArray());

    return $this->update(self::from($acc));
  }

  /**
   * {@inheritdoc}
   */
  public function mergeN(ImmutableList ...$lists): ImmutableList
  {
    return $this->merge(
      \array_shift($lists)
        ->triggerMutation(
          function ($list) use ($lists) {
            $idx = 0;

            while ($next = $lists[$idx] ?? null) {
              if (!$next instanceof ImmutableList) {
                break;
              }

              $list->merge($next);
              $idx++;
            }

            return $list;
          }
        )
    );
  }

  /**
   * {@inheritdoc}
   */
  public function reverse(): ImmutableList
  {
    $list   = $this->getList();

    if ($list instanceof Vector) {
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

    if ($list instanceof \SplFixedArray) {
      $iterator = $list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        $key        = $iterator->key();
        $list[$key] = $key >= $start && $key <= $end ?
          $value :
          $iterator->current();

        $iterator->next();
      }
    } else {
      $idx = 0;
      while (isset($list[$idx])) {
        $current    = $list[$idx];
        $list[$idx] = $idx >= $start && $idx <= $end ?
          $value :
          $current;

        $idx++;
      }
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

    if ($list instanceof \SplFixedArray) {
      $iterator = $list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        $current = $iterator->current();

        if (
          (\is_array($current) || \is_object($current)) &&
          f\keysExist($current, $key)
        ) {
          $extr[] = f\pluck($current, $key);
        }

        $iterator->next();
      }
    } else {
      $idx = 0;
      while (isset($list[$idx])) {
        $current = $list[$idx];

        if (
          (\is_array($current) || \is_object($current)) &&
          f\keysExist($current, $key)
        ) {
          $extr[] = f\pluck($current, $key);
        }

        $idx++;
      }
    }

    return self::from($extr);
  }

  /**
   * {@inheritdoc}
   */
  public function unique(): ImmutableList
  {
    $list = $this->getList();
    $acc  = [];

    if ($list instanceof \SplFixedArray) {
      $iterator = $list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        $current = $iterator->current();
        if (!\in_array($current, $acc)) {
          $acc[] = $current;
        }

        $iterator->next();
      }
    } else {
      $idx = 0;
      while (isset($list[$idx])) {
        $current = $list[$idx];

        if (!\in_array($current, $acc)) {
          $acc[] = $current;
        }

        $idx++;
      }
    }

    return self::from($acc);
  }

  /**
   * {@inheritdoc}
   */
  public function intersects(ImmutableList $list): bool
  {
    $current    = $this->getList();
    $intersect  = false;

    if ($current instanceof \SplFixedArray) {
      $iterator = $current->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        if (\in_array($iterator->current(), $list->toArray())) {
          $intersect = true;
          break;
        }

        $iterator->next();
      }
    } else {
      $idx = 0;
      while (isset($current[$idx])) {
        $next = $current[$idx];

        if (\in_array($next, $list->toArray())) {
          $intersect = true;
          break;
        }

        $idx++;
      }
    }

    return $intersect;
  }

  /**
   * {@inheritdoc}
   */
  public function implode(string $delimiter): string
  {
    return \preg_replace(
      \sprintf('/%s$/', \preg_quote($delimiter, '/')),
      '',
      $this->fold(
        function (string $fold, $elem) use ($delimiter) {
          $fold .= f\concat($delimiter, $elem, '');

          return $fold;
        },
        ''
      )
    );
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
    $any  = false;
    $list = $this->getList();

    if ($list instanceof \SplFixedArray) {
      $iterator = $list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        $current = $iterator->current();

        if ($func($current)) {
          $any = true;
          break;
        }

        $iterator->next();
      }
    } else {
      $idx = 0;
      while (isset($list[$idx])) {
        $current = $list[$idx];

        if ($func($current)) {
          $any = true;
          break;
        }

        $idx++;
      }
    }

    return $any;
  }

  /**
   * {@inheritdoc}
   */
  public function every(callable $func): bool
  {
    $every  = true;
    $list   = $this->getList();

    if ($list instanceof \SplFixedArray) {
      $iterator = $list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        $current = $iterator->current();

        if (!$func($current)) {
          $every = false;
          break;
        }

        $iterator->next();
      }
    } else {
      $idx = 0;
      while (isset($list[$idx])) {
        $current = $list[$idx];

        if (!$func($current)) {
          $every = false;
          break;
        }

        $idx++;
      }
    }

    return $every;
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
   * @return ImmutableList
   */
  private function filterOperation(callable $func, bool $pos = true): ImmutableList
  {
    $filter = [];
    $list   = $this->getList();

    if ($list instanceof \SplFixedArray) {
      $iterator = $list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        $current = $iterator->current();

        if ($pos ? $func($current) : !$func($current)) {
          $filter[] = $current;
        }

        $iterator->next();
      }
    } else {
      $idx = 0;
      while (isset($list[$idx])) {
        $current = $list[$idx];

        if ($pos ? $func($current) : !$func($current)) {
          $filter[] = $current;
        }

        $idx++;
      }
    }

    return self::from($filter);
  }
}
