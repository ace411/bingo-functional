<?php

/**
 * mcompose
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\fold;

const mcompose = __NAMESPACE__ . '\\mcompose';

/**
 * mcompose
 * composes two monadic functions from right to left
 *
 * mcompose :: m a -> n s -> n a
 *
 * @param callable $fx
 * @param callable $fy
 * @return object Monad
 */
function mcompose(callable $fx, callable $fy)
{
  return fold(
    function (callable $acc, callable $mfunc) {
      return function ($val) use ($acc, $mfunc) {
        return bind($acc, bind($mfunc, $val));
      };
    },
    [$fy],
    $fx
  );
}
