<?php

namespace Chemem\Bingo\Functional\Functors\Monads;

class ListMonad
{
    private $collection;

    public function __construct(...$collection)
    {
        $this->collection = $collection;
    }

    public static function of(...$collection)
    {
        return new static($collection);
    }

    public function get()
    {
        return $this->collection;
    }
}