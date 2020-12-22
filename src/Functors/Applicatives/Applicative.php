<?php

/**
 * Applicative functor.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicatives;

class Applicative
{
  const pure  = __CLASS__ . '::pure';

  const of    = __CLASS__ . '::of';

  /**
   * @var mixed $value Value in Applicative context
   */
  private $value;

  /**
   * constructor.
   *
   * @param mixed $value
   */
  public function __construct($value)
  {
    $this->value = $value;
  }

  /**
   * pure
   * lifts a value
   * 
   * pure :: Applicative f => a -> f a
   *
   * @static
   * @param mixed $value
   * @return object Applicative
   */
  public static function pure($value)
  {
    return new static($value);
  }

  /**
   * of
   * puts a value in an Applicative
   * 
   * ap :: a -> f a
   * 
   * @static
   * @param mixed $value
   * @return Applicative
   */
  public static function of($value): self
  {
    return new static($value);
  }

  /**
   * ap
   * replaces liftM and enables function application in Applicative environment
   *
   * ap :: Applicative f => f (a -> b) -> f a -> f b
   * 
   * @param Monadic
   * @return Monadic
   */
  public function ap(self $app): self
  {
    return self::pure($this->getValue()($app->getValue()));
  }

  /**
   * map
   * transforms Applicative state via function application and approximates do syntax
   *
   * map :: Applicative f => f a -> (a -> b) -> f b
   * 
   * @param callable $function The morphism used to transform the state value
   * @return Monadic
   */
  public function map(callable $function): self
  {
    return self::pure($function)->ap($this);
  }

  /**
   * getValue
   * unwraps Applicative revealing its contents
   * 
   * getValue :: Applicative => f a -> a
   *
   * @return mixed $value
   */
  public function getValue()
  {
    return $this->value;
  }
}
