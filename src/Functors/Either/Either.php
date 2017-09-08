<?php

/**
 * Either type functor
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Either;

use Chemem\Bingo\Functional\Common\Functors\FunctorInterface;

abstract class Either
{
    /**
     * left method
     *
     * @param mixed $value
     * @return object Left
     */

    public static function left($value) : Left
    {
        return new Left($value);
    }

    /**
     * right method
     *
     * @param mixed $value
     * @return object Right
     */

    public static function right($value) : Right
    {
        return new Right($value);
    }

    /**
     * partitionEithers method
     *
     * @param array $values
     * @param array $acc
     * @return array $acc
     */

    public static function partitionEithers(array $values, $acc = []) : array
    {
        $acc['left'] = array_map(
            function ($val) {
                return $val->getLeft();
            },
            array_filter($values, function ($val) {
                return $val instanceof Left;
            })
        );
        $acc['right'] = array_map(
            function ($val) {
                return $val->getRight();
            },
            array_filter($values, function ($val) {
                return $val instanceof Right;
            })
        );
        return $acc;
    }

    /**
     * getLeft method
     *
     * @abstract
     */

    abstract public function getLeft();

    /**
     * getRight method
     *
     * @abstract
     */

    abstract public function getRight();

    /**
     * isLeft method
     *
     * @abstract
     * @return boolean
     */

    abstract public function isLeft() : bool;

    /**
     * isRight method
     *
     * @abstract
     * @return boolean
     */

    abstract public function isRight() : bool;

    /**
     * flatMap method
     *
     * @abstract
     * @param callable $fn
     */

    abstract public function flatMap(callable $fn);

    /**
     * map method
     *
     * @abstract
     * @param callable $fn
     * @return object FunctorInterface
     */

    abstract public function map(callable $fn) : FunctorInterface;

    /**
     * filter method
     *
     * @abstract
     * @param callable $fn
     * @param mixed $error
     * @return object Either
     */

    abstract public function filter(callable $fn, $error) : Either;

    /**
     * orElse method
     *
     * @param Either $either
     * @return object Either
     */

    abstract public function orElse(Either $either) : Either;
}
