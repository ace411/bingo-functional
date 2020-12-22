<?php

/**
 * ListMonad helper functions.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use Chemem\Bingo\Functional\Functors\Monads\Monadic;
use Chemem\Bingo\Functional\Algorithms as f;

const fromValue = __NAMESPACE__ . '\\fromValue';

/**
 * fromValue
 * puts an arbitrary value in a List monad
 *
 * fromValue :: a -> ListMonad [a]
 *
 * @param mixed $value
 * @return ListMonad
 */
function fromValue($value): Monadic
{
  return (__NAMESPACE__ . '::of')($value);
}

const concat = __NAMESPACE__ . '\\concat';

/**
 * concat
 * creates a large list by merging multiple lists
 *
 * concat :: ListMonad [a] -> ListMonad [b] -> ListMonad [a, b]
 *
 * @param ListMonad $list
 * @return ListMonad
 */
function concat(Monadic ...$list): Monadic
{
  $res = f\fold(function (array $return, Monadic $list) {
    $return[] = $list->extract();

    return $return;
  }, $list, []);

  return fromValue(f\extend(...$res));
}

const prepend = __NAMESPACE__ . '\\prepend';

/**
 * prepend
 * inserts the items of one list into the beginning of another
 *
 * prepend :: ListMonad [a] -> ListMonad [b] -> ListMonad [a, b]
 *
 * @param ListMonad $value
 * @param ListMonad $list
 * @return ListMonad
 */
function prepend(Monadic $value, Monadic $list): Monadic
{
  return concat($value, $list);
}

const append = __NAMESPACE__ . '\\append';

/**
 * append
 * adds the items of one list to the end of another
 *
 * append :: ListMonad [a] -> ListMonad [b] -> ListMonad [b, a]
 *
 * @param ListMonad $value
 * @param ListMonad $list
 *
 * @return ListMonad
 */
function append(Monadic $value, Monadic $list): Monadic
{
  return concat($list, $value);
}

const head = __NAMESPACE__ . '\\head';

/**
 * head
 * returns the first element in a list
 *
 * head :: ListMonad [a, b] -> a
 *
 * @param ListMonad $list
 * @return mixed
 */
function head(Monadic $list)
{
  return $list->extract();
}

const tail = __NAMESPACE__ . '\\tail';

/**
 * tail
 * extracts elements after the head of a list
 *
 * tail :: [a] -> [a]
 *
 * @param ListMonad $list
 * @return object
 */
function tail(Monadic $list)
{
  // replace monoid with class containing unit type
  return new class() {
    public $value = null;
  };
}
