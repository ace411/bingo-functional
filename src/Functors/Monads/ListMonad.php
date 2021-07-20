<?php

/**
 * List monad
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Functors\Functor;
use Chemem\Bingo\Functional\Functors\ApplicativeFunctor;

use Chemem\Bingo\Functional as f;

class ListMonad implements Monad, Functor, ApplicativeFunctor
{
  public const of = __CLASS__ . '::of';

  /**
   * @property callable $listop ListMonad operation
   */
  private $listop;

  public function __construct(callable $listop)
  {
    $this->listop = $listop;
  }

  /**
   * of
   * puts value in ListMonad context
   *
   * of :: a -> ListMonad a
   *
   * @param mixed $val
   * @return Monad
   */
  public static function of($val): Monad
  {
    return new static(function () use ($val) {
      return \is_array($val) ? $val : [$val];
    });
  }

  /**
   * {@inheritdoc}
   */
  public function ap(ApplicativeFunctor $list): ApplicativeFunctor
  {
    return $list->map(...$this->extract());
  }

  /**
   * {@inheritdoc}
   */
  public function map(callable $function): Functor
  {
    return new static(function () use ($function) {
      return f\mapDeep($function, $this->extract());
    });
  }

  /**
   * {@inheritdoc}
   */
  public function bind(callable $function): Monad
  {
    return self::merge($function, $this->extract());
  }

  /**
   * unwraps the List monad
   *
   * extract :: ListMonad m a => [a]
   *
   * @return array
   */
  public function extract()
  {
    return ($this->listop)();
  }

  /**
   * merge
   * internally merges lists
   *
   * merge :: (a -> b) -> [b] -> m [a, b]
   *
   * @access private
   * @param callable $function
   * @param array $list
   * @return Monad
   */
  private static function merge(callable $function, $list)
  {
    $merge = f\compose(
      // transform every list entry in the list
      f\partial(f\fold, function ($acc, $val) use ($function) {
        $acc[] = $function($val)->extract();

        return $acc;
      }, $list),
      f\flatten
    );

    return new static(function () use ($merge) {
      return $merge([]);
    });
  }
}
