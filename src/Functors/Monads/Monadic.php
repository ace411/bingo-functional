<?php

/**
 *
 * Monadic interface for Monads
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

interface Monadic
{
  /**
   * map method
   *
   * @param callable $function The morphism used to transform the state value
   * @param mixed    $output
   *
   * @return object Monadic
   */
  public function map(callable $function): Monadic;

  /**
   * bind method.
   *
   * Analogous to the >>= method in Haskell
   *
   * @param callable $function
   *
   * @return object Monadic
   */
  public function bind(callable $function): Monadic;

  /**
   * ap method.
   *
   * In many situations, the liftM operations can be replaced by uses of ap, which promotes function application.
   *
   * @param object Monadic
   *
   * @return object Monadic
   */
  public function ap(Monadic $app): Monadic;
}
