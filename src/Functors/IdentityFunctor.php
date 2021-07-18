<?php

/**
 * Identity functor
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors;

class IdentityFunctor implements Functor
{
  public const of = __CLASS__ . '::of';

  /**
   * @var mixed $value value in Functor context
   */
  private $value;

  /**
   * constructor
   *
   * @param mixed $value
   */
  public function __construct($value)
  {
    $this->value = $value;
  }

  /**
   * of
   * puts a value in Functor context
   *
   * of :: a -> f a
   *
   * @static
   * @param mixed $value
   * @return Functor
   */
  public static function of($value): Functor
  {
    return new static($value);
  }

  /**
   * {@inheritDoc}
   */
  public function map(callable $function): Functor
  {
    return new static($function($this->value));
  }

  /**
   * getValue
   * unwraps Functor revealing its contents
   *
   * getValue :: Functor => f a -> a
   *
   * @return mixed $value
   */
  public function getValue()
  {
    return $this->value;
  }
}
