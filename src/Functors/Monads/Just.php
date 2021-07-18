<?php

/**
 * Just monad
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\ApplicativeFunctor;

class Just extends Maybe
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
  public function isJust(): bool
  {
    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function isNothing(): bool
  {
    return false;
  }

  /**
   * {@inheritdoc}
   */
  public function getJust()
  {
    return $this->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getNothing()
  {
  }

  /**
   * {@inheritdoc}
   */
  public function flatMap(callable $fn)
  {
    return $fn($this->getJust());
  }

  /**
   * {@inheritdoc}
   */
  public function getOrElse($default)
  {
    return $this->value;
  }

  /**
   * {@inheritdoc}
   */
  public function ap(ApplicativeFunctor $just): ApplicativeFunctor
  {
    return $this->bind(function ($action) use ($just) {
      return $just->map($action);
    });
  }

  /**
   * {@inheritdoc}
   */
  public function map(callable $fn): Functor
  {
    return new static($fn($this->getJust()));
  }

  /**
   * {@inheritdoc}
   */
  public function bind(callable $function): Monad
  {
    return $function($this->getJust());
  }

  /**
   * {@inheritdoc}
   */
  public function filter(callable $fn): Monad
  {
    return $fn($this->getJust()) ? $this : new Nothing();
  }

  /**
   * {@inheritdoc}
   */
  public function orElse(Maybe $maybe): Maybe
  {
    return $this;
  }
}
