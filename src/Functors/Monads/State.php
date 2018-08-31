<?php

/**
 * State monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

class State
{
    /**
     * @var mixed The transformed state
     */
    private $state;

    /**
     * @var mixed The initial state: value to transform
     */
    private $value;

    /**
     * State monad constructor.
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
     * of method.
     *
     * @static of
     *
     * @param mixed $initVal
     *
     * @return object State
     */
    public static function of($initVal)
    {
        return new static($initVal, $initVal);
    }

    /**
     * evalState method.
     *
     * @param callable $action
     *
     * @return object State
     */
    public function evalState(callable $action) : self
    {
        return new static(
            $this->value,
            call_user_func($action, $this->state)
        );
    }

    /**
     * ap method.
     *
     * @param object State
     *
     * @return object State
     */
    public function ap(self $app) : self
    {
        return $this->map(function ($val) use ($app) {
            return $app->map($val);
        });
    }

    /**
     * map method.
     *
     * @param callable $function
     *
     * @return object State
     */
    public function map(callable $function) : self
    {
        return $this->evalState($function);
    }

    /**
     * map method.
     *
     * @param callable $function
     *
     * @return mixed $result
     */
    public function flatMap(callable $function)
    {
        return $this
            ->evalState($function)
            ->exec();
    }

    /**
     * bind method.
     *
     * @param callable $action
     *
     * @return object State
     */
    public function bind(callable $function) : self
    {
        return $this->map($function);
    }

    /**
     * evalState method.
     *
     * @return array [$value, $state]
     */
    public function exec()
    {
        return [$this->value, $this->state];
    }
}
