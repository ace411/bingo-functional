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
    /**
     * @access private
     * @var mixed $state The transformed state
     */
    private $state;

    /**
     * @access private
     * @var mixed $value The initial state: value to transform 
     */
    private $value;

    /**
     * State monad constructor
     * 
     * @param mixed $value
     * @param mixed $state
     */
    public function __construct($value, $state)
    {
        $this->value = $value;
        $this->state = $state;
    }

    /**
     * of method
     * 
     * @static of
     * @param mixed $initVal
     * @return object State
     */

    public static function of($initVal) : State
    {
        return new static($initVal, $initVal);
    }

    /**
     * evalState method
     * 
     * @param callable $action
     * @return object State
     */

    public function evalState(callable $action) : State
    {
        return new static(
            $this->value,
            call_user_func($action, $this->state)
        );
    }

    /**
     * map method
     * 
     * @param callable $function
     * @return object State
     */

    public function map(callable $function) : State
    {
        return $this->evalState($function);
    }

    public function flatMap(callable $function)
    {
        return $this
            ->evalState($function)
            ->exec();
    }

    /**
     * bind method
     * 
     * @param callable $action
     * @return object State
     */

    public function bind(callable $function) : State
    {
        return $this->map($function);
    }

    /**
     * evalState method
     * 
     * @return array [$value, $state]
     */

    public function exec()
    {
        return [$this->value, $this->state];
    }
}