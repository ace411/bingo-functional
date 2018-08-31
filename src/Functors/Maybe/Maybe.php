<?php

/**
 * Maybe type abstract functor.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Maybe;

abstract class Maybe
{
    /**
     * just method.
     *
     * @param mixed $value
     *
     * @return object Just
     */
    public static function just($value) : Just
    {
        return new Just($value);
    }

    /**
     * nothing method.
     *
     * @return object Nothing
     */
    public static function nothing() : Nothing
    {
        return new Nothing();
    }

    /**
     * fromValue method.
     *
     * @param mixed $just
     * @param mixed $nothing
     *
     * @return object Maybe
     */
    public static function fromValue($just, $nothing = null) : self
    {
        return $just !== $nothing ? self::just($just) : self::nothing();
    }

    /**
     * lift method.
     *
     * @param callable $fn
     *
     * @return callable
     */
    public static function lift(callable $fn) : callable
    {
        return function () use ($fn) {
            if (
                array_reduce(
                    func_get_args($fn),
                    function ($status, Maybe $val) {
                        return $val->isNothing() ? false : $status;
                    },
                    true
                )
            ) {
                $args = array_map(
                    function (Maybe $maybe) {
                        return $maybe->getOrElse(null);
                    },
                    func_get_args($fn)
                );

                return self::just(call_user_func($fn, ...$args));
            }

            return self::nothing();
        };
    }

    /**
     * getJust method.
     *
     * @abstract
     */
    abstract public function getJust();

    /**
     * getNothing method.
     *
     * @abstract
     */
    abstract public function getNothing();

    /**
     * isJust method.
     *
     * @abstract
     *
     * @return bool
     */
    abstract public function isJust() : bool;

    /**
     * isNothing method.
     *
     * @abstract
     *
     * @return bool
     */
    abstract public function isNothing() : bool;

    /**
     * flatMap method.
     *
     * @abstract
     *
     * @param callable $fn
     *
     * @return mixed $value
     */
    abstract public function flatMap(callable $fn);

    /**
     * ap method.
     *
     * @abstract
     *
     * @param Maybe $app
     *
     * @return object Maybe
     */
    abstract public function ap(self $app) : self;

    /**
     * getOrElse method.
     *
     * @abstract
     *
     * @param mixed $default
     *
     * @return mixed $value
     */
    abstract public function getOrElse($default);

    /**
     * map method.
     *
     * @abstract
     *
     * @param callable $fn
     *
     * @return object Maybe
     */
    abstract public function map(callable $function) : self;

    /**
     * filter method.
     *
     * @abstract
     *
     * @param callable $fn
     *
     * @return object Maybe
     */
    abstract public function filter(callable $fn) : self;

    /**
     * orElse method.
     *
     * @abstract
     *
     * @param Maybe $value
     *
     * @return object Maybe
     */
    abstract public function orElse(self $value) : self;
}
