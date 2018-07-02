<?php

/**
 * Immutable Collection class
 * 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

class Collection implements \JsonSerializable, \IteratorAggregate, \Countable
{
    /**
     * @access private
     * @var mixed $list 
     */
    private $list;

    /**
     * Collection constructor
     * 
     * @param mixed $items
     */
    public function __construct($items)
    {
        $this->list = $items;
    }

    /**
     * from static method
     * 
     * @access public
     * @method from
     * @param mixed $item
     * @return object Collection
     */
    public static function from(...$items) : Collection
    {
        return new static(\SplFixedArray::fromArray($items));
    }

    /**
     * map method
     * 
     * @access public
     * @method map
     * @param callable $func
     * @return object Collection
     */
    public function map(callable $func) : Collection
    {
        $list = $this->list;
        
        foreach ($list as $index => $val) {
            $list[$index] = $func($val);
        }

        return new static($list);
    }

    /**
     * flatMap method
     * 
     * @access public
     * @method flatMap
     * @param callable $func
     * @return array $flattened
     */
    public function flatMap(callable $func) : array
    {
        $list = $this->list;
        $acc = [];

        foreach ($list as $val) {
            $acc[] = $func($val);
        }

        return $acc;
    }

    /**
     * filter method
     * 
     * @access public
     * @method filter
     * @param callable $func
     * @return object Collection
     */
    public function filter(callable $func) : Collection
    {
        $list = $this->list;
        $acc = [];
        
        foreach ($list as $index => $val) {
            if ($func($val)) { $acc[] = $val; }
        }

        return new static(\SplFixedArray::fromArray($acc));
    }

    /**
     * fold method
     * 
     * @access public
     * @method fold
     * @param callable $func
     * @param mixed $acc
     * @return object Collection
     */
    public function fold(callable $func, $acc) : Collection
    {
        $list = $this->list;

        foreach ($list as $val) {
            $acc = $func($acc, $val);
        }

        return new static($acc);
    }

    /**
     * slice method
     * 
     * @access public
     * @method slice
     * @param int $count
     * @return object Collection
     */
    public function slice(int $count) : Collection
    {
        $list = $this->list;
        $listCount = $list->count();
        $new = new \SplFixedArray($listCount - $count);

        foreach ($new as $index => $val) {
            $new[$index] = $list[($index + $count)];
        }

        return new static($new);
    }

    /**
     * merge method
     * 
     * @access public
     * @method merge
     * @param Collection $list
     * @return object Collection
     */
    public function merge(Collection $list) : Collection
    {
        $oldSize = $this->getSize();
        $combinedSize = $oldSize + $list->getSize();
        $old = $this->list;
        $old->setSize($combinedSize);

        foreach ($old as $index => $val) {
            if ($index > $oldSize - 1) {
                $old[$index] = $list->getList()[($index - $oldSize)];
            }
        }

        return new static($old);
    }

    /**
     * reverse method
     * 
     * @access public
     * @method reverse
     * @return object Collection
     */
    public function reverse() : Collection
    {
        $list = $this->list;
        $count = $this->list->getSize();
        $newList = new \SplFixedArray($count);        

        foreach ($newList as $index => $val) {
            $newList[$index] = $list[$count - $index - 1];
        }

        return new static($newList);
    }

    /**
     * getList method
     * 
     * @return mixed $list
     */
    public function getList()
    {
        return $this->list;
    }
    
    /**
     * jsonSerialize method
     * 
     * @return array $list
     */
    public function jsonSerialize()
    {
        return $this->list instanceof \SplFixedArray ? $this->list->toArray() : [$this->list];
    }

    /**
     * getSize method
     * 
     * @return int $size
     */
    public function getSize() : int
    {
        return $this->list instanceof \SplFixedArray ? ($this->list->getSize()) : 1;
    }

    /**
     * toArray method
     * 
     * @return array $list
     */
    public function toArray() : array
    {
        return $this->list instanceof \SplFixedArray ? ($this->list->toArray()) : [$this->list];
    }

    /**
     * getIterator method
     * 
     * @see ArrayIterator
     * @return object ArrayIterator
     */

    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->toArray());
    }

    /**
     * count method
     * 
     * @return int $count
     */
    public function count() : int
    {
        return $this->getSize();
    }
}