<?php

/**
 * Nothing type.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Maybe;

use \Chemem\Bingo\Functional\Functors\Monads as M;

class Nothing extends Maybe
{
  const of = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\Nothing::of';

  private $nothing;

  public function __construct()
  {
    $this->nothing = null;
  }

  /**
   * {@inheritdoc}
   */
  public static function of($value): Maybe
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
  public function ap(M\Monadic $app): M\Monadic
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
  public function map(callable $function): M\Monadic
  {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function filter(callable $fn): Maybe
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
  public function orElse(Maybe $maybe): Maybe
  {
    return $maybe;
  }
}
