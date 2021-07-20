<?php

/**
 * Reader monad
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\ApplicativeFunctor;

class Reader implements Monad, Functor, ApplicativeFunctor
{
  public const of = __CLASS__ . '::of';

  /**
   * @property callable $action Reader environment function
   */
  private $action;

  /**
   * Reader constructor
   *
   * @param callable $action
   */
  public function __construct($action)
  {
    $this->action = $action;
  }

  /**
   * of method
   * puts reader action in Reader environment
   *
   * of :: (r -> a) -> Reader r a
   *
   * @static of
   * @param mixed $action
   * @return Reader
   */
  public static function of($action): Monad
  {
    return \is_callable($action) ?
      new static($action) :
      new static(function ($env) use ($action) {
        return $action;
      });
  }

  /**
   * {@inheritDoc}
   */
  public function ap(ApplicativeFunctor $app): ApplicativeFunctor
  {
    return $this->bind(function ($func) use ($app) {
      return $app->map($func);
    });
  }

  /**
   * {@inheritDoc}
   */
  public function map(callable $function): Functor
  {
    return $this->bind(function ($env) use ($function) {
      return self::of($function($env));
    });
  }

  /**
   * {@inheritDoc}
   */
  public function bind(callable $function): Monad
  {
    return new self(function ($env) use ($function) {
      return $function($this->run($env))->run($env);
    });
  }

  /**
   * ask
   * returns monad environment
   *
   * ask :: Reader m a => m a
   *
   * @return mixed $action
   */
  public function ask()
  {
    return $this;
  }

  /**
   * run
   * runs Reader and extracts final value from it
   *
   * run :: Reader r => r a -> r -> a
   *
   * @param mixed $env
   * @return mixed $action
   */
  public function run($env)
  {
    return ($this->action)($env);
  }
}
