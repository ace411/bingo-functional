<?php

/**
 * Immutable ImmutableList class.
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

use \Chemem\Bingo\Functional\Algorithms as A;

class Collection implements \JsonSerializable, \IteratorAggregate, \Countable, ImmutableList
{
    use CommonTrait;

    /**
     * {@inheritdoc}
     */
    public function map(callable $func): ImmutableList
    {
        $count = $this->count();
        $list = new \SplFixedArray($count);
        for ($idx = 0; $idx < $count; $idx++) {
            $list[$idx] = $func($this->getList()[$idx]);
        }

        return new static($list);
    }

    /**
     * {@inheritdoc}
     */
    public function flatMap(callable $func): array
    {
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

        for ($idx = 0; $idx < $list->count(); $idx++) {
            $acc = $func($acc, $list[$idx]);
        }

        return $acc;
    }

    /**
     * {@inheritdoc}
     */
    public function slice(int $count): ImmutableList
    {
        $list       = $this->getList();
        $listCount  = $list->count();
        $new        = new \SplFixedArray($listCount - $count);

        for ($idx = 0; $idx < $new->count(); $idx++) {
            $new[$idx] = $list[$idx + $count];
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
        $old->setSize($combinedSize);

        for ($idx = 0; $idx < $old->count(); $idx++) {
            if ($idx > ($oldSize - 1)) {
                $old[$idx] = $list->getList()[($idx - $oldSize)];
            }
        }

        return new static($old);
    }

    /**
     * {@inheritdoc}
     */
    public function reverse(): ImmutableList
    {
        $list   = $this->getList();
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
            $list[$idx] = $idx >= $start && $idx <= $end ? $value : $list[$idx];
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
            if (is_array($item) && key_exists($key, $item)) {
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
            if (!in_array($item, $acc)) {
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
        $intersect  = [];
        $main       = $this->getSize();
        $oth        = $list->getSize();

        if ($main > $oth) {
            for ($idx = 0; $idx < $oth; $idx++) {
                $intersect[] = in_array($list->getList()[$idx], $this->toArray());
            }
        } elseif ($oth > $main) {
            for ($idx = 0; $idx < $main; $idx++) {
                $intersect[] = in_array($this->getList()[$idx], $list->toArray());
            }
        }

        return in_array(true, $intersect);
    }

    /**
     * {@inheritdoc}
     */
    public function implode(string $delimiter): string
    {
        return rtrim($this->fold(function (string $fold, $elem) use ($delimiter) {
            $fold .= A\concat($delimiter, $elem, '');
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
        return $this->filter($func)->getSize() >= 1 ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function every(callable $func): bool
    {
        $init = $this->getSize();

        return $this->filter($func)->getSize() == $init ? true : false;
    }

    /**
     * filterOperation function
     *
     * filterOperation :: (a -> Bool) -> Bool -> ImmutableList
     *
     * @param callable $func
     * @param bool $pos
     */
    private function filterOperation(callable $func, bool $pos = true): ImmutableList
    {
        $list   = $this->getList();
        $count  = $list->count();
        $new    = new \SplFixedArray($list->count());
        $init   = 0;

        for ($idx = 0; $idx < $count; $idx++) {
            if ($pos ? $func($list[$idx]) : !$func($list[$idx])) {
                $new[$init++] = $list[$idx];
            }
        }
        $new->setSize($init);

        return new static($new);
    }

    /**
     * offsetGet function
     *
     * @method offsetGet
     *
     * @param int $offset
     */
    public function offsetGet(int $offset)
    {
        if (!isset($this->list[$offset])) {
            throw new \OutOfRangeException('Offset does not exist');
        }

        return $this->list[$offset];
    }

    /**
     * getList method.
     *
     * @return mixed $list
     */
    public function getList(): \SplFixedArray
    {
        return $this->list;
    }

    /**
     * jsonSerialize method.
     *
     * @return array $list
     */
    public function jsonSerialize()
    {
        return $this->list instanceof \SplFixedArray ? $this->list->toArray() : [$this->list];
    }

    /**
     * getSize method.
     *
     * @return int $size
     */
    public function getSize(): int
    {
        return $this->count();
    }

    /**
     * toArray method.
     *
     * @return array $list
     */
    public function toArray(): array
    {
        return $this->list instanceof \SplFixedArray ? ($this->list->toArray()) : [$this->list];
    }

    /**
     * getIterator method.
     *
     * @see ArrayIterator
     *
     * @return object ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->toArray());
    }
}
