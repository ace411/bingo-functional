<?php

/**
 * List monad
 * 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function \Chemem\Bingo\Functional\Algorithms\{mapDeep, extend, compose, flatten, partialLeft};

class ListMonad
{
    /**
     * @access private
     * @var array $collection The collection to transform
     */
    private $collection = [];

    /**
     * ListMonad constructor
     * 
     * @param mixed $collection
     */

    public function __construct($collection)
    {
        $this->collection[] = $collection;
    }

    /**
     * of method
     * 
     * @param mixed $collection
     * @return object ListMonad
     */

    public static function of($collection) : ListMonad
    {
        return new static(is_array($collection) ? $collection : [$collection]);
    }

    /**
     * ap method
     * 
     * @param object ListMonad
     * @return object ListMonad
     */
    public function ap(ListMonad $app) : ListMonad
    {
        $list = $this->extract();

        $result = compose(
            partialLeft(\Chemem\Bingo\Functional\Algorithms\filter, function ($val) { return is_callable($val); }),
            partialLeft(
                \Chemem\Bingo\Functional\Algorithms\map, 
                function ($func) use ($list) {
                    $app = function (array $acc = []) use ($func, $list) { 
                        return mapDeep($func, $list);
                    };

                    return $app();
                }
            ),
            function ($result) use ($list) { return extend($list, ...$result); } 
        );

        return new static($result($app->extract()));
    }

    /**
     * bind method
     * 
     * @param callable $function
     * @return object ListMonad
     */

    public function bind(callable $function) : ListMonad
    {
        $concat = compose(
            function (array $list) use ($function) {
                return mapDeep($function, $list);
            },
            partialLeft('array_merge', $this->collection)
        );

        return self::of($concat($this->collection));
    }

    /**
     * map method
     * 
     * @param callable $function
     * @return object ListMonad
     */
    public function map(callable $function) : ListMonad
    {
        return $this->bind($function);
    }

    /**
     * flatMap method
     * 
     * @param callable $function
     * @return mixed $result
     */
    public function flatMap(callable $function)
    {
        return $this
            ->bind($function)
            ->extract();
    }

    /**
     * extract method
     * 
     * @return array $collection
     */
    public function extract() : array
    {
        return flatten(...$this->collection);
    }
}