<?php

/**
 * State monad.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\Applicatives\Applicable;

class State implements Monad, Functor, Applicable
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
  public static function of($initial): Monad
  {
    return new static(function ($final) use ($initial) {
      return [$initial, $final];
    });
  }

  /**
   * {@inheritDoc}
   */
  public function ap(Applicable $monad): Applicable
  {
    return $this->bind(function ($function) use ($monad) {
      return $monad->map($function);
    });
  }

  /**
   * {@inheritDoc}
   */
  public function bind(callable $function): Monad
  {
    return new self(function ($state) use ($function) {
      [$initial, $final] = $this->run($state);

      return $function($initial)->run($final);
    });
  }

  /**
   * {@inheritDoc}
   */
  public function map(callable $function): Functor
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
