<?php

/**
 * Either type functor.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Either;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\Applicatives\Applicable;
use Chemem\Bingo\Functional\Functors\Monads\Monad;
use Chemem\Bingo\Functional\Algorithms as f;

abstract class Either implements Monad, Functor, Applicable
{
  const left  = __CLASS__ . '::left';

  const right = __CLASS__ . '::right';

  const lift  = __CLASS__ . '::lift';
  
  /**
   * left
   * puts a value in Left context
   *
   * left :: a -> e a
   * 
   * @param mixed $value
   * @return Left
   */
  public static function left($value): Monad
  {
    return new Left($value);
  }

  /**
   * right
   * puts a value in Right context
   *
   * right :: a -> e a
   * 
   * @param mixed $value
   * @return Right
   */
  public static function right($value): Monad
  {
    return new Right($value);
  }

  /**
   * lift
   * converts a function to an Either-type action
   * 
   * lift :: (a -> b) -> c -> (e a -> e b) -> e a -> e b
   *
   * @param callable $function
   * @param Left $left
   * @return callable
   */
  public static function lift(callable $function, Monad $left): callable
  {
    return function () use ($function, $left) {
      if (
        f\fold(function (bool $status, Either $val) {
          return $val->isLeft() ? false : $status;
        }, \func_get_args($function), true)
      ) {
        $args = f\map(function (Either $either) {
          return $either
            ->orElse(Either::right(null))
            ->getRight();
        }, \func_get_args());

        return self::right($function(...$args));
      }

      return $left;
    };
  }

  /**
   * getLeft
   * unwraps Left value
   * 
   * getLeft :: Either => e a -> a
   *
   * @abstract
   * @return mixed
   */
  abstract public function getLeft();

  /**
   * getRight
   * unwraps Right value
   * 
   * getRight :: Either => e a -> a
   *
   * @abstract
   * @return mixed
   */
  abstract public function getRight();

  /**
   * isLeft
   * checks if the Either value is of type Left
   * 
   * isLeft :: Either => e a -> Bool
   *
   * @abstract
   * @return boolean
   */
  abstract public function isLeft(): bool;

  /**
   * isRight
   * checks if the Either value is of type Right
   * 
   * isRight :: Either => e a -> Bool
   *
   * @abstract
   * @return boolean
   */
  abstract public function isRight(): bool;

  /**
   * of
   * puts value in Either monad
   *
   * of :: a -> e a
   * 
   * @abstract
   * @param mixed $value
   * @return Either
   */
  abstract public static function of($value): Monad;

  /**
   * flatMap
   * behaves like map but returns an unwrapped value
   * 
   * flatMap :: Either => e a -> (a -> b) -> b
   *
   * @abstract
   * @param callable $function
   * @return mixed
   */
  abstract public function flatMap(callable $function);

  /**
   * {@inheritDoc}
   */
  abstract public function map(callable $function): Functor;

  /**
   * {@inheritDoc}
   */
  abstract public function bind(callable $function): Monad;

  /**
   * {@inheritDoc}
   */
  abstract public function ap(Applicable $app): Applicable;

  /**
   * filter
   * retains value that satisfies boolean predicate; Left-wrapped error value otherwise
   *
   * filter :: Either => e a -> (a -> Bool) -> b -> e a
   * 
   * @abstract
   * @param callable $filter
   * @param mixed $error
   * @return Either
   */
  abstract public function filter(callable $filter, $error): Monad;

  /**
   * orElse
   * chainable version of left()/right()
   * 
   * orElse :: Either e a => e b -> e a
   *
   * @abstract
   * @param Either $either
   * @return Either
   */
  abstract public function orElse(Either $either): Either;
}
