<?php

/**
 * State monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

class State implements Monadic
{
    const of = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State::of';

    /**
     * @var callable The state computation to store
     */
    private $comp;

    /**
     * State monad constructor.
     *
     * @param callable $comp
     */
    public function __construct(callable $comp)
    {
        $this->comp = $comp;
    }

    /**
     * of method.
     *
     * @param callable $value The initial state
     *
     * @return object State
     */
    public static function of($value) : self
    {
        return new static(function ($state) use ($value) {
            return [$value, $state];
        });
    }

    /**
     * ap method.
     *
     * @param object State $monad
     *
     * @return object State
     */
    public function ap(Monadic $monad) : Monadic
    {
        return $this->bind(function ($function) use ($monad) {
            return $monad->map($function);
        });
    }

    /**
     * bind method.
     *
     * @param callable $function
     *
     * @return object State
     */
    public function bind(callable $function) : Monadic
    {
        return new self(function ($state) use ($function) {
            list($initial, $final) = $this->run($state);

            return $function($initial)->run($final);
        });
    }

    /**
     * map method.
     *
     * @param callable $function
     *
     * @return object State
     */
    public function map(callable $function) : Monadic
    {
        return $this->bind(function ($state) use ($function) {
            return self::of($function($state));
        });
    }

    /**
     * run method.
     *
     * @return array
     */
    public function run($state)
    {
        return call_user_func($this->comp, $state);
    }
}
