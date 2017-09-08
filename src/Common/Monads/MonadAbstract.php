<?php

/**
 * MonadAbstract class
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Common\Monads;

use Chemem\Bingo\Functional\Common\Applicatives\ApplicativeAbstract;

abstract class MonadAbstract extends ApplicativeAbstract
{
    /**
     * Monadic return method
     *
     * @param mixed $value
     * @return object MonadAbstract
     */

    public static function return($value) : MonadAbstract
    {
        return static::pure($value);
    }

    /**
     * Monadic bind method
     *
     * @param callable $fn
     * @return object MonadAbstract
     */

    abstract public function bind(callable $fn) : MonadAbstract;
}
