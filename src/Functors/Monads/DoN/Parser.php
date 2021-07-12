<?php

/**
 * Do Notation execution parser
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\DoN;

use Chemem\Bingo\Functional\Functors\Monads as m;
use Chemem\Bingo\Functional\Algorithms as f;
use FunctionalPHP\PatternMatching as p;

class Parser
{
  /**
   * @var array $table Primitive symbol table for parser-storable monad objects
   */
  private $table = [];

  /**
   * Parser constructor
   *
   * @param array $table
   */
  public function __construct(array $table = [])
  {
    $this->table = $table;
  }

  /**
   * assign
   * adds an object (monad or Context instance) to the parser's symbol table
   *
   * assign :: Parser p => p [m a] -> String -> m a -> p [m a]
   *
   * @param string $var
   * @param object $object
   * @return Parser
   */
  public function assign(string $var, $object)
  {
    return new static(
      f\extend($this->table, [$var => $object])
    );
  }

  /**
   * extract
   * applies selected table monad objects to lifted monadic action
   *
   * extract :: Parser p => p [m a] -> Array -> (a -> b) -> m b
   *
   * @param array $args
   * @param callable $action
   * @return Monad
   */
  public function extract(array $args, callable $action): m\Monad
  {
    // invoke Monadic action with Monad objects stored in symbol table
    return m\liftM(
      $action,
      // extract Monad objects sans-keys
      ...\array_values(
        f\map(f\partial(f\pluck, $this->table), $args)
      )
    );
  }
}
