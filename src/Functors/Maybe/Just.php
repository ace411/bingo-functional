<?php

/**
 * Just type functor.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Maybe;

use \Chemem\Bingo\Functional\Functors\Monads as M;

class Just extends Maybe
{
    const of = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\Just::of';

    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function of($value): Maybe
    {
        return new static($value);
    }

    /**
     * {@inheritdoc}
     */
    public function isJust(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isNothing(): bool
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
    public function ap(M\Monadic $just): M\Monadic
    {
        return $this->bind(function ($action) use ($just) {
            return $just->map($action);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $fn): M\Monadic
    {
        return new static($fn($this->getJust()));
    }

    /**
     * {@inheritdoc}
     */
    public function bind(callable $function): M\Monadic
    {
        return $function($this->getJust());
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $fn): Maybe
    {
        return $fn($this->getJust()) ? new static($this->getJust()) : new Nothing();
    }

    /**
     * {@inheritdoc}
     */
    public function orElse(Maybe $maybe): Maybe
    {
        return !isset($this->value) ? $maybe : new static($this->value);
    }
}
