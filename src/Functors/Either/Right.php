<?php

/**
 * Right type functor
 *
 * @package bingo-functional
 * @license Apache 2.0
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Functors\Either;

use Chemem\Bingo\Functional\Common\Functors\FunctorInterface;

final class Right extends Either implements FunctorInterface
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */

    public function isLeft() : bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */

    public function isRight() : bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */

    public function getLeft()
    {
        return null;
    }

    /**
     * @inheritdoc
     */

    public function getRight()
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */

    public function filter(callable $fn, $error) : Either
    {
        return $fn($this->value) ?
            new static($this->getRight()) :
            new Left($error);
    }

    /**
     * @inheritdoc
     */

    public function flatMap(callable $fn)
    {
        return $fn($this->getRight());
    }

    /**
     * @inheritdoc
     */

    public function map(callable $fn) : FunctorInterface
    {
        return new static($fn($this->getRight()));
    }

    /**
     * @inheritdoc
     */

    public function orElse(Either $either) : Either
    {
        return isset($this->value) || ($this->value instanceof Left) == false ?
            new static($this->getRight()) :
            new static($either->getRight());
    }
}
