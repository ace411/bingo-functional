<?php

/**
 * Left type functor.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Either;

class Left extends Either
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
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isRight() : bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getLeft()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getRight()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $function, $error) : Either
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function ap(Either $app) : Either
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flatMap(callable $function)
    {
        return $this->getLeft();
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $function) : Either
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function bind(callable $function)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function orElse(Either $either) : Either
    {
        return $either;
    }
}
