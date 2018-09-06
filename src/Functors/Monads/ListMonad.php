<?php

/**
 * List monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\Algorithms\compose;
use function Chemem\Bingo\Functional\Algorithms\extend;
use function Chemem\Bingo\Functional\Algorithms\flatten;
use function Chemem\Bingo\Functional\Algorithms\map;
use function Chemem\Bingo\Functional\Algorithms\partialLeft;

class ListMonad
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
    public static function of($collection) : self
    {
        return new static(is_array($collection) ? $collection : [$collection]);
    }

    /**
     * ap method.
     *
     * @param object ListMonad
     *
     * @return object ListMonad
     */
    public function ap(self $app) : self
    {
        $list = $this->extract();

        $result = compose(
            partialLeft(\Chemem\Bingo\Functional\Algorithms\filter, function ($val) {
                return is_callable($val);
            }),
            partialLeft(
                \Chemem\Bingo\Functional\Algorithms\map,
                function ($func) use ($list) {
                    $app = function (array $acc = []) use ($func, $list) {
                        return map($func, $list);
                    };

                    return $app();
                }
            ),
            function ($result) use ($list) {
                return extend($list, ...$result);
            }
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
    public function bind(callable $function) : self
    {
        list($original, $final) = State::of($this->extract())
            ->map(partialLeft(\Chemem\Bingo\Functional\Algorithms\map, $function))
            ->exec();

        return new static(extend($final, $original));
    }

    /**
     * map method.
     *
     * @param callable $function
     *
     * @return object ListMonad
     */
    public function map(callable $function) : self
    {
        return $this->bind($function);
    }

    /**
     * flatMap method.
     *
     * @param callable $function
     *
     * @return mixed $result
     */
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
