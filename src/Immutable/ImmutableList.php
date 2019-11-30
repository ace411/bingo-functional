<?php

declare(strict_types=1);

namespace Chemem\Bingo\Functional\Immutable;

interface ImmutableList extends ImmutableDataStructure
{
    /**
     * map method.
     *
     * @method map
     * @see https://ace411.github.io/bingo-functional/#/collection?id=map-function
     * @param callable $func
     *
     * @return ImmutableList
     */
    public function map(callable $func): ImmutableList;

    /**
     * filter method.
     *
     * @method filter
     * @see https://ace411.github.io/bingo-functional/#/collection?id=filter-function
     * @param callable $func
     *
     * @return ImmutableList
     */
    public function filter(callable $func): ImmutableList;

    /**
     * fold method.
     *
     * @method fold
     * @see https://ace411.github.io/bingo-functional/#/collection?id=foldreduce-function
     * @param callable $func
     * @param mixed    $acc
     *
     * @return mixed $acc
     */
    public function fold(callable $func, $acc);

    /**
     * flatMap method.
     *
     * @method flatMap
     *
     * @param callable $func
     *
     * @return array
     */
    public function flatMap(callable $func): array;

    /**
     * slice method.
     *
     * @method slice
     *
     * @param int $count
     *
     * @return ImmutableList
     */
    public function slice(int $count): ImmutableList;

    /**
     * merge method.
     *
     * @method merge
     *
     * @param ImmutableList $list
     *
     * @return ImmutableList
     */
    public function merge(ImmutableList $list): ImmutableList;

    /**
     * mergeN method.
     *
     * @method merge
     *
     * @param ImmutableList... $list
     *
     * @return ImmutableList
     */
    public function mergeN(ImmutableList ...$lists): ImmutableList;
    
    /**
     * reverse method.
     *
     * @method reverse
     *
     * @return ImmutableList
     */
    public function reverse(): ImmutableList;

    /**
     * fill method.
     *
     * @method fill
     *
     * @param mixed $value
     * @param int   $start
     * @param int   $end
     *
     * @return ImmutableList
     */
    public function fill($value, int $start, int $end): ImmutableList;

    /**
     * fetch method
     *
     * @method fetch
     *
     * @param mixed key
     *
     * @return ImmutableList
     */
    public function fetch($key): ImmutableList;

    /**
     * unique method
     *
     * @method unique
     * @see https://ace411.github.io/bingo-functional/#/collection?id=unique-function
     *
     * @return ImmutableList
     */
    public function unique(): ImmutableList;

    /**
     * intersects method
     *
     * @method head
     *
     * @param ImmutableList $list
     *
     * @return bool
     */
    public function intersects(ImmutableList $list): bool;

    /**
     * implode function
     *
     * @method implode
     *
     * @param string $delimiter
     *
     * @return string
     */
    public function implode(string $glue): string;

    /**
     * reject method.
     *
     * @method reject
     * @see https://ace411.github.io/bingo-functional/#/collection?id=reject-function
     * @param callable $func
     *
     * @return ImmutableList
     */
    public function reject(callable $func): ImmutableList;

    /**
     * any method
     *
     * @method any
     * @see
     * @param callable $func
     *
     * @return ImmutableList
     */
    public function any(callable $func): bool;

    /**
     * every method
     *
     * @method every
     * @see
     * @param callable $func
     *
     * @return ImmutableList
     */
    public function every(callable $func): bool;
}
