<?php

/**
 * Nothing type.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Maybe;

class Nothing extends Maybe
{
    private $nothing;

    public function __construct()
    {
        $this->nothing = null;
    }

    /**
     * {@inheritdoc}
     */
    public function isJust() : bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isNothing() : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getNothing()
    {
        return $this->nothing;
    }

    /**
     * {@inheritdoc}
     */
    public function getJust()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function flatMap(callable $fn)
    {
        return $this->getNothing();
    }

    /**
     * {@inheritdoc}
     */
    public function ap(Maybe $app) : Maybe
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrElse($default)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $function) : Maybe
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $fn) : Maybe
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function orElse(Maybe $maybe) : Maybe
    {
        return $maybe;
    }
}
