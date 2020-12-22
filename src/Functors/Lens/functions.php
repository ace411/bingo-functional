<?php

/**
 * Lens functions
 *
 * @see https://ramdajs.com/docs/#lens
 * @see https://medium.com/@dtipson/functional-lenses-d1aba9e52254
 * @see https://medium.com/javascript-scene/lenses-b85976cb0534
 * @see https://hackage.haskell.org/package/data-lens-light-0.1.2.2/docs/Data-Lens-Light.html#v:lens
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Lens;

use Chemem\Bingo\Functional\Algorithms as f;

const _const = __NAMESPACE__ . '\\_const';

/**
 * _const
 * creates a constant functor (Const)
 *
 * _const :: a -> f a
 *
 * @param mixed $entity
 * @return object
 */
function _const($entity)
{
  return new class($entity) {
    public $val;

    public function __construct($val)
    {
      $this->val = $val;
    }

    public function map()
    {
      return $this;
    }
  };
}

const _identity = __NAMESPACE__ . '\\_identity';

/**
 * _identity
 * creates an identity functor (Identity)
 *
 * _identity :: a -> f a
 *
 * @param mixed $entity
 * @return object
 */
function _identity($entity)
{
  return new class($entity) {
    public $val;

    public function __construct($val)
    {
      $this->val = $val;
    }

    public function map(callable $operation)
    {
      return new static($operation($this->val));
    }
  };
}

const lens = __NAMESPACE__ . '\\lens';

/**
 * lens
 * builds a lens out of a getter and setter
 *
 * lens :: (s -> a) -> ((a, s) -> s) -> Lens s a
 *
 * @param callable $get
 * @param callable $set
 * @return callable
 */
function lens(callable $get, callable $set): callable
{
  return function ($func) use ($get, $set) {
    // apply functor function (Const, Identity)
    return function ($list) use ($get, $set, $func) {
      // apply list (array, object)
      return $func($get($list))
        ->map(
          function ($replacement) use ($set, $list) {
            // apply setter to list item
            return $set($replacement, $list);
          }
        );
    };
  };
}

const lensFromKey = __NAMESPACE__ . '\\lensFromKey';

/**
 * lensFromKey
 * creates a lens from a list index, functor-wrapped getter, and list
 *
 * lensFromKey :: a -> (b -> f b) -> [b] -> f b
 *
 * @param mixed $key
 * @param callable $getter
 * @param mixed $list
 * @return object
 */
function lensFromKey($key, callable $getter, $list)
{
  // transform key-specific value with getter
  return $getter(f\pluck($list, $key))
    ->map(
      function ($replacement) use ($list, $key) {
        // create shallow list clone
        return f\assoc($key, $replacement, $list);
      }
    );
}

const lensKey = __NAMESPACE__ . '\\lensKey';

/**
 * lensKey
 * creates a lens whose focus is an arbitrary list key
 *
 * lensKey :: a -> (b -> f b)
 *
 * @param mixed $key
 * @return callable
 */
function lensKey($key): callable
{
  return f\curry(lensFromKey)($key);
}

const view = __NAMESPACE__ . '\\view';

/**
 * view
 * extracts the focus of a lens
 *
 * view :: (a -> f a) -> [a] -> a
 *
 * @param callable $lens
 * @param mixed $store
 * @return mixed
 */
function view(callable $lens, $store)
{
  $obj = $lens(_const)($store);

  return $obj->val;
}

const over = __NAMESPACE__ . '\\over';

/**
 * over
 * applies a function to the focus of a lens
 *
 * over :: (a -> f a) -> (a -> b) -> [a] -> b
 *
 * @param callable $lens
 * @param callable $operation
 * @param mixed $store
 * @return mixed
 */
function over(callable $lens, callable $operation, $store)
{
  $obj = $lens(function ($res) use ($operation) {
    // transform value in lens context
    return _identity($operation($res));
  })($store);

  return $obj->val;
}

const set = __NAMESPACE__ . '\\set';

/**
 * set
 * updates an entity associated with the focus of a lens
 *
 * set :: (a -> f a) -> b -> [a] -> [b]
 *
 * @param callable $lens
 * @param mixed $value
 * @param mixed $store
 * @return mixed
 */
function set(callable $lens, $value, $store)
{
  return over($lens, f\constantFunction($value), $store);
}

const lensPath = __NAMESPACE__ . '\\lensPath';

/**
 * lensPath
 * creates a lens from a path
 *
 * lensPath :: [b] -> Lens s a
 *
 * @param mixed ...$fragments
 * @return callable
 */
function lensPath(...$fragments): callable
{
  return lens(
    f\curry(f\pluckPath)($fragments),
    f\curry(f\assocPath)($fragments)
  );
}
