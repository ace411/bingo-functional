<?php

declare(strict_types=1);

/**
 * Immutable Common trait
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

use Ds\Vector;
use Chemem\Bingo\Functional as f;

trait CommonTrait
{
  /**
   * @var $list
   * @access private
   */
  private $list;

  /**
   * Immutable constructor
   *
   * @param SplFixedArray|Vector $list
   */
  public function __construct($list)
  {
    $this->list = $list;
  }

  /**
   * @see ImmutableList
   * {@inheritdoc}
   */
  public static function from(array $list): ImmutableDataStructure
  {
    // add support for ext-ds
    return new static(
      \extension_loaded('ds') ?
        new Vector($list) :
        \SplFixedArray::fromArray($list)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function contains($element): bool
  {
    $exists = false;

    if ($this->list instanceof \SplFixedArray) {
      $iterator = $this->list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        $current = $iterator->current();

        if ($current instanceof ImmutableDataStructure) {
          $exists = $next->contains($element);
        } elseif (\is_array($current) || \is_object($current)) {
          $exists = self::checkContains($current, $element);
        } else {
          $exists = f\equals($current, $element, true);
        }

        if ($exists) {
          break;
        }

        $iterator->next();
      }
    } else {
      $idx = 0;
      while (isset($this->list[$idx])) {
        $current = $this->list[$idx];

        if ($current instanceof ImmutableDataStructure) {
          $exists = $next->contains($element);
        } elseif (\is_array($current) || \is_object($current)) {
          $exists = self::checkContains($current, $element);
        } else {
          $exists = f\equals($current, $element, true);
        }

        if ($exists) {
          break;
        }

        $idx++;
      }
    }

    return $exists;
  }

  /**
   * {@inheritdoc}
   */
  public function head()
  {
    if ($this->list instanceof \SplFixedArray) {
      $iterator = $this->list->getIterator();
      $iterator->rewind();

      return $iterator->current();
    }

    return $this->list->first();
  }

  /**
   * {@inheritdoc}
   */
  public function tail(): ImmutableDataStructure
  {
    $list   = $this->list;
    $acc    = [];
    $idx    = 1;

    if ($this->list instanceof \SplFixedArray) {
      $iterator = $this->list->getIterator();
      $iterator->rewind();

      while ($iterator->valid()) {
        if ($iterator->key() >= $idx) {
          $acc[] = $iterator->current();
        }

        $iterator->next();
      }
    } else {
      while (isset($this->list[$idx])) {
        $value = $this->list[$idx];
        $acc[] = $value;

        $idx++;
      }
    }

    return self::from($acc);
  }

  /**
   * {@inheritdoc}
   */
  public function last()
  {
    return $this->list instanceof \SplFixedArray ?
      $this->list[$this->count() - 1] :
      $this->list->last();
  }

  /**
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
   * @see https://php.net/manual/en/class.countable.php
   * {@inheritdoc}
   */
  public function count(): int
  {
    return $this->list instanceof \SplFixedArray ?
      $this->list->getSize() :
      $this->list->count();
  }

  /**
   * checkContains
   *
   * checkContains :: [a] -> Bool
   *
   * @param array|object $list
   * @return bool
   */
  private static function checkContains($haystack, $needle): bool
  {
    $exists = false;

    foreach ($haystack as $value) {
      if (\is_object($value) || \is_array($value)) {
        $exists = self::checkContains($value, $needle);
      }

      if (f\equals($needle, $value, true)) {
        $exists = true;
        break;
      }
    }

    return $exists;
  }
}
