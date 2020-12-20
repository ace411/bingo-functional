<?php

/**
 * Reader monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

class Reader implements Monadic
{
  const of = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader::of';

  /**
   * @var callable The operation to use to lazily evaluate an environment variable
   */
  private $action;

  /**
   * Reader constructor.
   *
   * @param callable $action
   */
  public function __construct($action)
  {
    $this->action = $action;
  }

  /**
   * of method.
   *
   * @static of
   *
   * @param mixed $action
   *
   * @return object Reader
   */
  public static function of($action): self
  {
    return \is_callable($action) ? new static($action) : new static(function ($env) use ($action) {
      return $action;
    });
  }

  /**
   * ap method.
   */
  public function ap(Monadic $app): Monadic
  {
    return $this->bind(function ($func) use ($app) {
      return $app->map($func);
    });
  }

  /**
   * map method.
   *
   * @param callable $action
   *
   * @return object Reader
   */
  public function map(callable $function): Monadic
  {
    return $this->bind(function ($env) use ($function) {
      return self::of($function($env));
    });
  }

  /**
   * bind method.
   */
  public function bind(callable $function): Monadic
  {
    return new self(function ($env) use ($function) {
      return $function($this->run($env))->run($env);
    });
  }

  /**
   * ask method.
   *
   * @return mixed $action
   */
  public function ask()
  {
    return $this->action;
  }

  /**
   * run method.
   *
   * @param mixed $env Environment variable
   *
   * @return mixed $action
   */
  public function run($env)
  {
    return \call_user_func($this->action, $env);
  }
}
