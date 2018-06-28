<?php

namespace Chemem\Bingo\Functional\Immutable;

class Collection implements \JsonSerializable
{
    private $list;

    public function __construct($items)
    {
        $this->list = $items;
    }

    public static function from(...$items) : Collection
    {
        return new static(\SplFixedArray::fromArray($items));
    }

    public function map(callable $func) : Collection
    {
        $list = $this->list;
        $count = $list->count();
        $newList = new \SplFixedArray($count);

        $map = function (int $init = 0) use (&$map, $list, $func, $count, $newList) {
            if ($init >= $count) { return new static($newList); }

            $newList[$init] = $func($list->offsetGet($init));

            return $map($init + 1);
        };
        
        return $map();
    }

    public function flatMap(callable $func) : array
    {
        $list = $this->list;
        $count = $list->count();

        $flatMap = function (int $init = 0, array $acc = []) use ($list, $func, $count, &$flatMap) {
            if ($init >= $count) { return $acc; }

            $acc[] = $func($list->offsetGet($init));

            return $flatMap($init + 1, $acc);
        };

        return $flatMap();
    }

    public function filter(callable $func) : Collection
    {
        $list = $this->list;
        $count = $list->count();
        
        $filter = function (int $init = 0, array $acc = []) use ($func, $list, $count, &$filter) {
            if ($init >= $count) { return new static(\SplFixedArray::fromArray($acc)); }

            if ($func($list->offsetGet($init))) { $acc[] = $list->offsetGet($init); }

            return $filter($init + 1, $acc);
        };

        return $filter();
    }

    public function fold(callable $func, $acc)
    {
        $list = $this->list;
        $count = $list->count();

        $fold = function (int $init = 0, $mult) use ($list, $func, $count, &$fold) {
            if ($init >= $count) { return new static(\SplFixedArray::fromArray(is_array($mult) ? $mult: [$mult])); }

            $mult = $func($mult, $list->offsetGet($init));

            return $fold($init + 1, $mult);
        };

        return $fold(0, $acc);
    }

    public function merge(Collection $list)
    {
        $oldSize = $this->getSize();
        $combinedSize = $oldSize + $list->getSize();
        $old = $this->list;
        $old->setSize($combinedSize);

        $merge = function (int $init, int $base) use ($list, $old, &$merge, $combinedSize) {
            if ($init >= $combinedSize) { return new static($old); }

            $old[$init] = $list->getList()->offsetGet($base);

            return $merge($init + 1, $base + 1);
        };

        return $merge($oldSize, 0);
    }

    public function getList()
    {
        return $this->list;
    }

    public function jsonSerialize()
    {
        return $this->list->toArray();
    }

    public function getSize() : int
    {
        return $this->list instanceof \SplFixedArray ? ($this->list->getSize()) : 1;
    }

    public function toArray() : array
    {
        return $this->list instanceof \SplFixedArray ? ($this->list->toArray()) : [$this->list];
    }
}