<?php

/**
 * Left type functor.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Either;

use Chemem\Bingo\Functional\Common\Functors\FunctorInterface;

final class Left extends Either implements FunctorInterface
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
    public function filter(callable $fn, $error) : Either
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flatMap(callable $fn)
    {
        return $this->getLeft();
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $fn) : FunctorInterface
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
