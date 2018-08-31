<?php

/**
 * Right type functor.
 *
 * @license Apache 2.0
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Functors\Either;

class Right extends Either
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function isLeft() : bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isRight() : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getLeft()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getRight()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function ap(Either $app) : Either
    {
        return $app->bind($this->value);
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $function, $error) : Either
    {
        return $function($this->value) ? new static($this->getRight()) : new Left($error);
    }

    /**
     * {@inheritdoc}
     */
    public function flatMap(callable $function)
    {
        return $function($this->getRight());
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $function) : Either
    {
        return new static($function($this->getRight()));
    }

    /**
     * {@inheritdoc}
     */
    public function bind(callable $function)
    {
        return $this->map($function);
    }

    /**
     * {@inheritdoc}
     */
    public function orElse(Either $either) : Either
    {
        return !isset($this->value) ? $either : new static($this->value);
    }
}
