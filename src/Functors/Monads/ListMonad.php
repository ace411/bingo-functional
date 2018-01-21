<?php

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Algorithms as A;

class ListMonad
{
    private $collection;

    public function __construct(...$collection)
    {
        $this->collection = $collection;
    }

    public static function of(...$collection) : ListMonad
    {
        return new static($collection);
    }

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

    public function extract() : array
    {
        return A\flatten($this->collection);
    }
}