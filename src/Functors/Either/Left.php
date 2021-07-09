<?php

/**
 * Left type functor.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Either;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\Applicatives\Applicable;
use Chemem\Bingo\Functional\Functors\Monads\Monad;

class Left extends Either
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
  public function filter(callable $function, $error): Monad
  {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function ap(Applicable $app): Applicable
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
  public function map(callable $function): Functor
  {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function bind(callable $function): Monad
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
