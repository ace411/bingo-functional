<?php

/**
 * IO monad.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\Algorithms\constantFunction;

class IO implements Monadic
{
  const of = __CLASS__ . '::of';

  /**
   * @property callable $unsafe The unsafe operation to execute in an IO environment 
   */
  private $unsafe;

  /**
   * IO monad constructor.
   *
   * @param callable $unsafe
   */
  public function __construct(callable $unsafe)
  {
    $this->unsafe = $unsafe;
  }

  /**
   * of
   * puts value in IO context
   *
   * of :: a -> m a
   * 
   * @static of
   * @param callable $unsafe
   * @return IO
   */
  public static function of($unsafe): self
  {
    return new static(\is_callable($unsafe) ? $unsafe : constantFunction($unsafe));
  }

  /**
   * {@inheritDoc}
   */
  public function ap(Monadic $app): Monadic
  {
    return $app->map($this->exec());
  }

  /**
   * {@inheritDoc}
   */
  public function map(callable $function): Monadic
  {
    return $this->bind(function ($unsafe) use ($function) {
      return self::of($function($unsafe));
    });
  }

  /**
   * {@inheritDoc}
   */
  public function bind(callable $function): Monadic
  {
    return $function($this->exec());
  }

  /**
   * exec method
   * unwraps unsafe operation
   *
   * @return mixed
   */
  public function exec()
  {
    return ($this->unsafe)();
  }
}
