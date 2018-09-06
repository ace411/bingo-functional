<?php

/**
 * Just type functor.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Maybe;

class Just extends Maybe
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function isJust() : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isNothing() : bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getJust()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getNothing()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function flatMap(callable $fn)
    {
        return $fn($this->getJust());
    }

    /**
     * {@inheritdoc}
     */
    public function getOrElse($default)
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function ap(Maybe $app) : Maybe
    {
        return $app->map($this);
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $fn) : Maybe
    {
        return new static($fn($this->getJust()));
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $fn) : Maybe
    {
        return $fn($this->getJust()) ? new static($this->getJust()) : new Nothing();
    }

    /**
     * {@inheritdoc}
     */
    public function orElse(Maybe $maybe) : Maybe
    {
        return !isset($this->value) ? $maybe : new static($this->value);
    }
}
