<?php

/**
 * State monad.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

class State implements Monadic
{
  const of = __CLASS__ . '::of';

  /**
   * @property callable $comp The state computation to store
   */
  private $comp;

  /**
   * State monad constructor.
   *
   * @param callable $comp
   */
  public function __construct(callable $comp)
  {
    $this->comp = $comp;
  }

  /**
   * of
   * puts an initial state in State monad
   * 
   * of :: s -> State s a
   *
   * @param callable $value
   * @return State
   */
  public static function of($initial): self
  {
    return new static(function ($final) use ($initial) {
      return [$initial, $final];
    });
  }

  /**
   * {@inheritDoc}
   */
  public function ap(Monadic $monad): Monadic
  {
    return $this->bind(function ($function) use ($monad) {
      return $monad->map($function);
    });
  }

  /**
   * {@inheritDoc}
   */
  public function bind(callable $function): Monadic
  {
    return new self(function ($state) use ($function) {
      [$initial, $final] = $this->run($state);

      return $function($initial)->run($final);
    });
  }

  /**
   * {@inheritDoc}
   */
  public function map(callable $function): Monadic
  {
    return $this->bind(function ($state) use ($function) {
      return self::of($function($state));
    });
  }

  /**
   * run
   * unwraps State monad
   *
   * run :: State s a => s -> (a, s)
   * 
   * @return array
   */
  public function run($state)
  {
    return ($this->comp)($state);
  }
}
