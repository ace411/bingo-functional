<?php

/**
 * IO monad.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\Applicatives\Applicable;

use function Chemem\Bingo\Functional\Algorithms\constantFunction;

class IO implements Monad, Functor, Applicable
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
  public static function of($unsafe): Monad
  {
    return new static(\is_callable($unsafe) ? $unsafe : constantFunction($unsafe));
  }

  /**
   * {@inheritDoc}
   */
  public function ap(Applicable $app): Applicable
  {
    return $app->map($this->exec());
  }

  /**
   * {@inheritDoc}
   */
  public function map(callable $function): Functor
  {
    return $this->bind(function ($unsafe) use ($function) {
      return self::of($function($unsafe));
    });
  }

  /**
   * {@inheritDoc}
   */
  public function bind(callable $function): Monad
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
