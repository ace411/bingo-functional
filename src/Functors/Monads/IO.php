<?php

/**
 * IO monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use \FunctionalPHP\FantasyLand\{Functor, Apply, Monad};
use function \Chemem\Bingo\Functional\Algorithms\constantFunction;

class IO implements Monad
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
    public function __construct(callable $operation)
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

    public static function of($operation)
    {
        return new static(is_callable($operation) ? $operation : constantFunction($operation));
    }

    /**
     * ap method
     * 
     * @inheritdoc
     */
    public function ap(Apply $app) : Apply
    {
        return $app->map($this->exec());
    }

    /**
     * map method
     * 
     * @inheritdoc
     */
    public function map(callable $function) : Functor
    {
        return self::of(call_user_func($function, $this->exec()));
    }

    /**
     * bind method
     * 
     * @inheritdoc
     */
    public function bind(callable $function)
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
        return call_user_func($this->operation);
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
        return call_user_func($function, $this->exec());
    }
}
