<?php

/**
 * State monad
 * 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

class State
{
    private $comp;

    public function __construct(callable $comp)
    {
        $this->comp = $comp;
    }

    public static function of($value) : State
    {
        return new static(function ($state) use ($value) {
            return [$value, $state];
        });
    }

    public function ap(State $monad) : State
    {
        return $state->map(function ($function) use ($monad) {
            return $monad->map($function);
        });
    }

    public function bind(callable $function) : State
    {
        return new self(function ($state) use ($function) {
            list($initial, $final) = $this->run($state);

            return $function($initial)->run($final);
        });
    }

    public function map(callable $function) : State
    {
        return $this->bind(function ($state) use ($function) {
            return self::of($function($state));
        });
    }

    public function run($state)
    {
        return call_user_func($this->comp, $state);
    }
}