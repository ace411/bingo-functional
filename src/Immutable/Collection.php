<?php

/**
 * Immutable Collection class.
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

use function Chemem\Bingo\Functional\Algorithms\trampoline;

class Collection implements \JsonSerializable, \IteratorAggregate, \Countable
{
    /**
     * @var mixed
     */
    private $list;

    /**
     * Collection constructor.
     *
     * @param mixed $items
     */
    public function __construct($items)
    {
        $this->list = $items;
    }

    /**
     * from static method.
     *
     * @method from
     *
     * @param mixed $item
     *
     * @return object Collection
     */
    public static function from(...$items) : self
    {
        return new static(\SplFixedArray::fromArray($items));
    }

    /**
     * map method.
     *
     * @method map
     *
     * @param callable $func
     *
     * @return object Collection
     */
    public function map(callable $func) : self
    {
        $list = $this->list;
        $count = $list->count();
        $newList = new \SplFixedArray($count);

        $map = trampoline(
            function (int $init = 0) use (&$map, $list, $func, $count, $newList) {
                if ($init >= $count) {
                    return new static($newList);
                }

                $newList[$init] = $func($list->offsetGet($init));

                return $map($init + 1);
            }
        );

        return $map();
    }

    /**
     * flatMap method.
     *
     * @method flatMap
     *
     * @param callable $func
     *
     * @return array $flattened
     */
    public function flatMap(callable $func) : array
    {
        $list = $this->list;
        $count = $list->count();

        $flatMap = trampoline(
            function (int $init = 0, array $acc = []) use ($list, $func, $count, &$flatMap) {
                if ($init >= $count) {
                    return $acc;
                }

                $acc[] = $func($list->offsetGet($init));

                return $flatMap($init + 1, $acc);
            }
        );

        return $flatMap();
    }

    /**
     * filter method.
     *
     * @method filter
     *
     * @param callable $func
     *
     * @return object Collection
     */
    public function filter(callable $func) : self
    {
        $list = $this->list;
        $count = $list->count();

        $filter = trampoline(
            function (int $init = 0, array $acc = []) use ($func, $list, $count, &$filter) {
                if ($init >= $count) {
                    return new static(\SplFixedArray::fromArray($acc));
                }

                if ($func($list->offsetGet($init))) {
                    $acc[] = $list->offsetGet($init);
                }

                return $filter($init + 1, $acc);
            }
        );

        return $filter();
    }

    /**
     * fold method.
     *
     * @method fold
     *
     * @param callable $func
     * @param mixed    $acc
     *
     * @return object Collection
     */
    public function fold(callable $func, $acc) : self
    {
        $list = $this->list;
        $count = $list->count();

        $fold = trampoline(
            function (int $init, $mult) use ($list, $func, $count, &$fold) {
                if ($init >= $count) {
                    return new static(\SplFixedArray::fromArray(is_array($mult) ? $mult : [$mult]));
                }

                $mult = $func($mult, $list->offsetGet($init));

                return $fold($init + 1, $mult);
            }
        );

        return $fold(0, $acc);
    }

    /**
     * slice method.
     *
     * @method slice
     *
     * @param int $count
     *
     * @return object Collection
     */
    public function slice(int $count) : self
    {
        $list = $this->list;
        $listCount = $list->count();
        $newList = new \SplFixedArray($listCount - $count);

        $drop = trampoline(
            function (int $init, int $base = 0) use ($newList, $listCount, $list, &$drop) {
                if ($init >= $listCount) {
                    return new static($newList);
                }

                $newList[$base] = $list->offsetGet($init);

                return $drop($init + 1, $base + 1);
            }
        );

        return $drop($count);
    }

    /**
     * merge method.
     *
     * @method merge
     *
     * @param Collection $list
     *
     * @return object Collection
     */
    public function merge(self $list) : self
    {
        $oldSize = $this->getSize();
        $combinedSize = $oldSize + $list->getSize();
        $old = $this->list;
        $old->setSize($combinedSize);

        $merge = trampoline(
            function (int $init, int $base) use ($list, $old, &$merge, $combinedSize) {
                if ($init >= $combinedSize) {
                    return new static($old);
                }

                $old[$init] = $list->getList()->offsetGet($base);

                return $merge($init + 1, $base + 1);
            }
        );

        return $merge($oldSize, 0);
    }

    /**
     * reverse method.
     *
     * @method reverse
     *
     * @return object Collection
     */
    public function reverse() : self
    {
        $list = $this->list;
        $count = $this->list->getSize();
        $newList = new \SplFixedArray($count);

        $reverse = trampoline(
            function (int $init, int $base = 0) use ($list, $count, $newList, &$reverse) {
                if ($init < 0 && $base >= $count) {
                    return new static($newList);
                }

                $newList[$base] = $list[$init];

                return $reverse($init - 1, $base + 1);
            }
        );

        return $reverse($count - 1);
    }

    /**
     * getList method.
     *
     * @return mixed $list
     */
    public function getList()
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
    public function getSize() : int
    {
        return $this->list instanceof \SplFixedArray ? ($this->list->getSize()) : 1;
    }

    /**
     * toArray method.
     *
     * @return array $list
     */
    public function toArray() : array
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
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->toArray());
    }

    /**
     * count method.
     *
     * @return int $count
     */
    public function count() : int
    {
        return $this->getSize();
    }
}
