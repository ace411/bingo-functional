<?php

/**
 * List monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use \FunctionalPHP\FantasyLand\{Apply, Functor, Monad};
use function \Chemem\Bingo\Functional\Algorithms\{map, extend, compose, flatten, partialLeft};

class ListMonad implements Monad
{
    /**
     * @var array The collection to transform
     */
    private $collection;

    /**
     * ListMonad constructor.
     *
     * @param mixed $collection
     */

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * of method.
     *
     * @param mixed $collection
     *
     * @return object ListMonad
     */

    public static function of($collection)
    {
        return new static(is_array($collection) ? $collection : [$collection]);
    }

    public function ap(Apply $app) : Apply
    {
        $list = $this->extract();

        $result = compose(
            partialLeft(\Chemem\Bingo\Functional\Algorithms\filter, function ($val) { return is_callable($val); }),
            partialLeft(
                \Chemem\Bingo\Functional\Algorithms\map, 
                function ($func) use ($list) {
                    $app = function (array $acc = []) use ($func, $list) { 
                        return map($func, $list);
                    };

                    return $app();
                }
            ),
            function ($result) use ($list) { return extend($list, ...$result); } 
        );

        return new static($result($app->extract()));
    }

    /**
     * bind method.
     *
     * @param callable $function
     *
     * @return object ListMonad
     */

    public function bind(callable $function)
    {
        list($original, $final) = State::of($this->extract())
            ->map(partialLeft(\Chemem\Bingo\Functional\Algorithms\map, $function))
            ->exec();

        return new static(extend($final, $original));
    }

    public function map(callable $function) : Functor
    {
        return $this->bind($function);
    }

    public function flatMap(callable $function)
    {
        return $this
            ->bind($function)
            ->extract();
    }

    /**
     * extract method.
     *
     * @return array $collection
     */
    public function extract() : array
    {
        return flatten($this->collection);
    }
}
