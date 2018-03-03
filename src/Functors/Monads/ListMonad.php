<?php

/**
 * List monad
 * 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Algorithms as A;

class ListMonad
{
    /**
     * @access private
     * @var array $collection The collection to transform
     */
    private $collection;

    /**
     * ListMonad constructor
     * 
     * @param mixed $collection
     */

    public function __construct(...$collection)
    {
        $this->collection = $collection;
    }

    /**
     * of method
     * 
     * @param mixed $collection
     * @return object ListMonad
     */

    public static function of(...$collection) : ListMonad
    {
        return new static($collection);
    }

    /**
     * bind method
     * 
     * @param callable $function
     * @return object ListMonad
     */

    public function bind(callable $function) : ListMonad
    {
        list($original, $final) = State::of($this->extract())
            ->map(
                A\partialLeft(
                    A\map,
                    $function
                )
            )
            ->exec();

        return new static(A\extend($final, $original));
    }

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
        return A\flatten($this->collection);
    }
}