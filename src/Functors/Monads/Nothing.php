<?php

/**
 * Nothing monad
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\ApplicativeFunctor;

class Nothing extends Maybe
{
  public const of = __CLASS__ . '::of';

  private $nothing;

  public function __construct()
  {
    $this->nothing = null;
  }

  /**
   * {@inheritdoc}
   */
  public static function of($value): Monad
  {
    return new self();
  }

  /**
   * {@inheritdoc}
   */
  public function isJust(): bool
  {
    return false;
  }

  /**
   * {@inheritdoc}
   */
  public function isNothing(): bool
  {
    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function getNothing()
  {
    return $this->nothing;
  }

  /**
   * {@inheritdoc}
   */
  public function getJust()
  {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function flatMap(callable $fn)
  {
    return $this->getNothing();
  }

  /**
   * {@inheritdoc}
   */
  public function ap(ApplicativeFunctor $app): ApplicativeFunctor
  {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOrElse($default)
  {
    return $default;
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
  public function filter(callable $fn): Monad
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
  public function orElse(Maybe $maybe): Maybe
  {
    return $maybe;
  }
}
