<?php

/**
 * ApplicativeAbstract class
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Common\Applicatives;

use Chemem\Bingo\Functional\Common\Functors\FunctorInterface;

abstract class ApplicativeAbstract implements FunctorInterface
{
    /**
     * Pure method
     *
     * @param mixed $value
     * @return object ApplicativeAbstract
     * @abstract
     */

    abstract public static function pure($value) : ApplicativeAbstract;

    /**
     * Apply method
     *
     * @param object ApplicativeAbstract
     * @return object ApplicativeAbstract
     * @abstract
     */

    abstract public function apply(ApplicativeAbstract $applicative) : ApplicativeAbstract;

    /**
     * Map method
     *
     * @param callable $fn
     * @return object FunctorInterface
     */

    public function map(callable $fn) : FunctorInterface
    {
        return $this->pure($fn)->apply($this);
    }
}
