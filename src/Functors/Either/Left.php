<?php

/**
 * Left type functor.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Either;

use \Chemem\Bingo\Functional\Functors\Monads as M;

class Left extends Either
{
  const of = 'Chemem\\Bingo\\Functional\\Functors\\Either\\Left::of';

  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  /**
   * {@inheritdoc}
   */
  public static function of($value): Either
  {
    return new static($value);
  }

  /**
   * {@inheritdoc}
   */
  public function isLeft(): bool
  {
    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function isRight(): bool
  {
    return false;
  }

  /**
   * {@inheritdoc}
   */
  public function getLeft()
  {
    return $this->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getRight()
  {
  }

  /**
   * {@inheritdoc}
   */
  public function filter(callable $function, $error): Either
  {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function ap(M\Monadic $app): M\Monadic
  {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function flatMap(callable $function)
  {
    return $this->getLeft();
  }

  /**
   * {@inheritdoc}
   */
  public function map(callable $function): M\Monadic
  {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function bind(callable $function): M\Monadic
  {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function orElse(Either $either): Either
  {
    return $either;
  }
}
