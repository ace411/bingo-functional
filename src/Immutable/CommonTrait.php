<?php

declare(strict_types=1);

/**
 * Immutable Common trait
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

use \Chemem\Bingo\Functional\Algorithms as f;

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
         * @param array $list
         */
    public function __construct(\SplFixedArray $list)
    {
        $this->list = $list;
    }

    /**
     * @see ImmutableList
     * {@inheritdoc}
     */
    public static function from(array $list): ImmutableDataStructure
    {
        return new static(\SplFixedArray::fromArray($list));
    }

    /**
     * {@inheritdoc}
     */
    public function contains($element): bool
    {
        $list   = $this->list;
        $count  = $list->count();
        $acc    = [];

        for (
            $idx = 0; $idx < $count; $idx++
        ) {
            $item  = $list[$idx];
            $acc[] = \is_array($item) ?
                f\mapDeep(function ($val) use ($element): bool {
                    return $val == $element;
                }, $item) :
                $element == $item;
        }

        return self::checkContains($acc);
    }

    /**
     * {@inheritdoc}
     */
    public function head()
    {
        return $this->list[0];
    }

    /**
     * {@inheritdoc}
     */
    public function tail(): ImmutableDataStructure
    {
        $list   = $this->list;
        $acc    = [];

        for (
            $idx = 1; $idx < $list->count(); $idx++
        ) {
            $acc[] = $list[$idx];
        }

        return self::from($acc);
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        return $this->list[$this->count() - 1];
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
     * @see https://php.net/manual/en/class.countable.php
     * {@inheritdoc}
     */
    public function count(): int
    {
        return ($this->list)->getSize();
    }

    /**
     * checkContains function
     *
     * checkContains :: [a] -> Bool
     *
     * @param array $list
     */
    private static function checkContains(array $list): bool
    {
        $comp = f\compose(f\flatten, function (array $val) {
            return \in_array(true, $val);
        });
        return $comp($list);
    }
}
