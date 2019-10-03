<?php

/**
 * Immutable Collection class.
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

use \Chemem\Bingo\Functional\Algorithms as A;

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
    public function __construct(\SplFixedArray $items)
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
    public static function from(array $items) : Collection
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
    public function map(callable $func) : Collection
    {
        $list = $this->getList();
        for ($idx = 0; $idx < $list->count(); $idx++) {
            $list[$idx] = $func($list[$idx]); 
        }

        return new static($list);
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
        return $this->map($func)->toArray();
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
    public function filter(callable $func) : Collection
    {
        $list   = $this->getList();
        $count  = $list->count();
        $new    = new \SplFixedArray($list->count());
        $init   = 0;

        for ($idx = 0; $idx < $count; $idx++) {
            if ($func($list[$idx])) {
                $new[$init++] = $list[$idx];
            }
        }
        $new->setSize($init);

        return new static($new);
    }

    /**
     * fold method.
     *
     * @method fold
     *
     * @param callable $func
     * @param mixed    $acc
     *
     * @return mixed $acc
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
     * slice method.
     *
     * @method slice
     *
     * @param int $count
     *
     * @return object Collection
     */
    public function slice(int $count) : Collection
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
     * merge method.
     *
     * @method merge
     *
     * @param Collection $list
     *
     * @return object Collection
     */
    public function merge(self $list) : Collection
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
     * reverse method.
     *
     * @method reverse
     *
     * @return object Collection
     */
    public function reverse() : Collection
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
     * fill method.
     *
     * @method fill
     *
     * @param mixed $value
     * @param int   $start
     * @param int   $end
     *
     * @return object Collection
     */
    public function fill($value, int $start, int $end): Collection
    {
        $list = $this->getList();

        for ($idx = 0; $idx < $list->count(); $idx++) {
            $list[$idx] = $idx >= $start && $idx <= $end ? $value : $list[$idx];
        }

        return new static($list);
    }

    /**
     * fetch method
     *
     * @method fetch
     *
     * @param mixed key
     */
    public function fetch($key) : Collection
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
     * checkContains function
     *
     * checkContains :: [a] -> Bool
     *
     * @param array $list
     */
    private static function checkContains(array $list) : bool
    {
        $comp = A\compose(A\flatten, function (array $val) {
            return in_array(true, $val);
        });
        return $comp($list);
    }

    /**
     * contains method
     *
     * @method contains
     *
     * @param mixed element
     */
    public function contains($element) : bool
    {
        $list   = $this->getList();
        $count  = $list->count();
        $acc    = [];

        for ($idx = 0; $idx < $count; $idx++) {
            $item = $list[$idx];
            $acc[] = is_array($item) ? 
                A\mapDeep(function ($val) use ($element): bool {
                    return $val == $element;
                }, $item) : 
                $element == $item;
        }

        return self::checkContains($acc);
    }

    /**
     * unique method
     *
     * @method unique
     */
    public function unique() : Collection
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
     * head method
     *
     * @method head
     */
    public function head()
    {
        return $this->list[0];
    }

    /**
     * tail method
     *
     * @method tail
     */
    public function tail() : Collection
    {
        $list   = $this->getList();
        $acc    = [];

        for ($idx = 1; $idx < $list->count(); $idx++) {
            $acc[] = $list[$idx];
        }

        return self::from($acc);
    }

    /**
     * last method
     *
     * @method last
     */
    public function last()
    {
        return $this->list[$this->getSize() - 1];
    }

    /**
     * intersects method
     *
     * @method head
     *
     * @param object Collection
     */
    public function intersects(Collection $list) : bool
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
     * implode function
     *
     * @method implode
     *
     * @param string $delimiter
     */
    public function implode(string $delimiter) : string
    {
        return rtrim($this->fold(function (string $fold, $elem) use ($delimiter) {
            $fold .= A\concat($delimiter, $elem, '');
            return $fold;
        }, ''), $delimiter);
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
