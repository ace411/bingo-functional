<?php

/**
 * Either type functor.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Either;

use function Chemem\Bingo\Functional\Algorithms\compose;
use function Chemem\Bingo\Functional\Algorithms\partialLeft;

abstract class Either
{
    /**
     * left method.
     *
     * @param mixed $value
     *
     * @return object Left
     */
    public static function left($value) : Left
    {
        return new Left($value);
    }

    /**
     * right method.
     *
     * @param mixed $value
     *
     * @return object Right
     */
    public static function right($value) : Right
    {
        return new Right($value);
    }

    /**
     * partitionEithers method.
     *
     * @param array $values
     * @param array $acc
     *
     * @return array $acc
     */
    public static function partitionEithers(array $values, $acc = []) : array
    {
        $partition = compose(
            partialLeft(\Chemem\Bingo\Functional\Algorithms\filter, function ($val) {
                return $val instanceof Either;
            }),
            function ($eithers) use ($acc) {
                foreach ($eithers as $either) {
                    if ($either instanceof Right) {
                        $acc['right'][] = $either->getRight();
                    } elseif ($either instanceof Left) {
                        $acc['left'][] = $either->getLeft();
                    }
                }

                return $acc;
            }
        );

        return $partition($values);
    }

    /**
     * lift method.
     *
     * @param callable $function
     * @param Left     $left
     *
     * @return callable
     */
    public static function lift(callable $function, Left $left) : callable
    {
        return function () use ($function, $left) {
            if (
                array_reduce(
                    func_get_args($function),
                    function (bool $status, Either $val) {
                        return $val->isLeft() ? false : $status;
                    },
                    true
                )
            ) {
                $args = array_map(
                    function (Either $either) {
                        return $either
                            ->orElse(Either::right(null))
                            ->getRight();
                    },
                    func_get_args()
                );

                return self::right(call_user_func($function, ...$args));
            }

            return $left;
        };
    }

    /**
     * getLeft method.
     *
     * @abstract
     */
    abstract public function getLeft();

    /**
     * getRight method.
     *
     * @abstract
     */
    abstract public function getRight();

    /**
     * isLeft method.
     *
     * @abstract
     *
     * @return bool
     */
    abstract public function isLeft() : bool;

    /**
     * isRight method.
     *
     * @abstract
     *
     * @return bool
     */
    abstract public function isRight() : bool;

    /**
     * flatMap method.
     *
     * @abstract
     *
     * @param callable $function
     */
    abstract public function flatMap(callable $function);

    /**
     * map method.
     *
     * @see FunctionalPHP\FantasyLand\Functor
     * @abstract
     *
     * @param callable $function
     *
     * @return object Functor
     */
    abstract public function map(callable $function) : self;

    /**
     * bind method.
     *
     * @see FunctionalPHP\FantasyLand\Chain
     * @abstract
     *
     * @param callable $function
     *
     * @return object Either
     */
    abstract public function bind(callable $function);

    /**
     * ap method.
     *
     * @see FunctionalPHP\FantasyLand\Apply
     * @abstract
     *
     * @param Either $app
     *
     * @return object Either
     */
    abstract public function ap(self $app) : self;

    /**
     * filter method.
     *
     * @abstract
     *
     * @param callable $function
     * @param mixed    $error
     *
     * @return object Either
     */
    abstract public function filter(callable $function, $error) : self;

    /**
     * orElse method.
     *
     * @param Either $either
     *
     * @return object Either
     */
    abstract public function orElse(self $either) : self;
}
