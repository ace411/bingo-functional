<?php

/**
 * IO monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

class IO
{
    /**
     * @var callable The unsafe operation to perform
     */
    private $operation;

    /**
     * IO monad constructor.
     *
     * @param callable $operation
     */
    public function __construct($operation)
    {
        $this->operation = $operation;
    }

    /**
     * of method.
     *
     * @static of
     *
     * @param callable $operation
     *
     * @return object IO
     */
    public static function of(callable $operation) : self
    {
        return new static(call_user_func($operation));
    }

    /**
     * map method.
     *
     * @param callable $function
     *
     * @return object IO
     */
    public function map(callable $function) : self
    {
        return new static(call_user_func($function, $this->operation));
    }

    /**
     * bind method.
     *
     * @param callable $function
     *
     * @return object IO
     */
    public function bind(callable $function) : self
    {
        return $this->map($function);
    }

    /**
     * exec method.
     *
     * @return $operation
     */
    public function exec()
    {
        return $this->operation;
    }

    /**
     * flatMap method.
     *
     * @param callable $function
     *
     * @return mixed $operation
     */
    public function flatMap(callable $function)
    {
        return call_user_func($function, $this->operation);
    }
}
