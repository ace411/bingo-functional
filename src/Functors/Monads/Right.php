<?php

/**
 * Right monad
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\ApplicativeFunctor;

class Right extends Either
{
  public const of = __CLASS__ . '::of';

  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  /**
   * {@inheritdoc}
   */
  public static function of($value): Monad
  {
    return new static($value);
  }

  /**
   * {@inheritdoc}
   */
  public function isLeft(): bool
  {
    return false;
  }

  /**
   * {@inheritdoc}
   */
  public function isRight(): bool
  {
    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function getLeft()
  {
  }

  /**
   * {@inheritdoc}
   */
  public function getRight()
  {
    return $this->value;
  }

  /**
   * {@inheritdoc}
   */
  public function ap(ApplicativeFunctor $right): ApplicativeFunctor
  {
    return $this->bind(
      function ($function) use ($right) {
        return $right->map($function);
      }
    );
  }

  /**
   * {@inheritdoc}
   */
  public function filter(callable $function, $error): Monad
  {
    return $function($this->value) ?
      new static($this->getRight()) :
      new Left($error);
  }

  /**
   * {@inheritdoc}
   */
  public function flatMap(callable $function)
  {
    return $function($this->getRight());
  }

  /**
   * {@inheritdoc}
   */
  public function map(callable $function): Functor
  {
    return new static($function($this->getRight()));
  }

  /**
   * {@inheritdoc}
   */
  public function bind(callable $function): Monad
  {
    return $function($this->getRight());
  }

  /**
   * {@inheritdoc}
   */
  public function orElse(Either $either): Either
  {
    return $this;
  }
}
