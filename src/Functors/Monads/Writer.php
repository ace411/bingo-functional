<?php

/**
 * Writer monad.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\ApplicativeFunctor;

use function Chemem\Bingo\Functional\extend;

class Writer implements Monad, Functor, ApplicativeFunctor
{
  public const of = __CLASS__ . '::of';

  /**
   * @property callable $action Writer monad action
   */
  private $action;

  public function __construct(callable $action)
  {
    $this->action = $action;
  }

  /**
   * of
   * puts result and output in Writer monad
   *
   * of :: a -> w -> Writer (a, w)
   *
   * @static of
   * @param mixed $result
   * @param mixed $output
   * @return Writer
   */
  public static function of($result, $output = null): Monad
  {
    return new static(function () use ($result, $output) {
      return [$result, \is_null($output) ? [] : [$output]];
    });
  }

  /**
   * {@inheritDoc}
   */
  public function ap(ApplicativeFunctor $app): ApplicativeFunctor
  {
    return $this->bind(function ($function) use ($app) {
      return $app->map($function);
    });
  }

  /**
   * {@inheritDoc}
   */
  public function map(callable $function): Functor
  {
    return new static(function () use ($function) {
      [$result, $output] = $this->run();

      return [$function($result), $output];
    });
  }

  /**
   * {@inheritDoc}
   */
  public function bind(callable $function): Monad
  {
    return new static(function () use ($function) {
      [$result, $output]  = $this->run();
      [$res, $out]        = $function($result)->run();

      return [$res, extend($output, $out)];
    });
  }

  /**
   * run
   * unwraps Writer monad revealing result and output data
   *
   * run :: Writer a w => (a, w)
   *
   * @return array
   */
  public function run(): array
  {
    return ($this->action)();
  }
}
