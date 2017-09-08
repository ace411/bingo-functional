<?php

/**
 * Nothing type
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Maybe;

use Chemem\Bingo\Functional\Common\Functors\FunctorInterface;

final class Nothing extends Maybe implements FunctorInterface
{
    private $nothing;

    public function __construct()
    {
        $this->nothing = null;
    }

    /**
     * @inheritdoc
     */

    public function isJust() : bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */

    public function isNothing() : bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */

    public function getNothing()
    {
        return $this->nothing;
    }

    /**
     * @inheritdoc
     */

    public function getJust()
    {
        return null;
    }

    /**
     * @inheritdoc
     */

    public function flatMap(callable $fn)
    {
        return $this->getNothing();
    }

    /**
     * @inheritdoc
     */

    public function getOrElse($default)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */

    public function map(callable $fn) : FunctorInterface
    {
        return $this;
    }

    /**
     * @inheritdoc
     */

    public function filter(callable $fn) : Maybe
    {
        return $this;
    }

    /**
     * @inheritdoc
     */

    public function orElse(Maybe $value) : Maybe
    {
        return $this;
    }
}
