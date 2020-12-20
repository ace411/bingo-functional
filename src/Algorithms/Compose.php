<?php

/**
 * Compose function.
 *
 * compose :: f (g a) -> compose f g a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const compose = 'Chemem\\Bingo\\Functional\\Algorithms\\compose';

function compose(callable ...$functions): callable
{
  return fold(function ($id, $fn) {
    return function ($val) use ($id, $fn) {
      return $fn($id($val));
    };
  }, $functions, identity);
}

const composeRight = 'Chemem\\Bingo\\Functional\\Algorithms\\composeRight';

function composeRight(callable ...$functions): callable
{
  return compose(...\array_reverse($functions));
}
