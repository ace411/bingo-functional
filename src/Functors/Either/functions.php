<?php

/**
 * Either type helper functions.
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Either;

use Chemem\Bingo\Functional\Functors\Monads\Monad;
use Chemem\Bingo\Functional\Algorithms as f;

const either = __NAMESPACE__ . '\\either';

/**
 * either function
 * Case analysis for the either type.
 *
 * either :: (a -> c) -> (b -> c) -> Either a b -> c
 *
 * @param callable $left
 * @param callable $right
 * @param object Either
 * @return mixed
 */
function either(
  callable $left,
  callable $right,
  Monad $either
) {
  return $either instanceof Left ?
    $left($either->getLeft()) :
    $right($either->getRight());
}

/**
 * _extract
 * extracts one of either Right or Left types
 *
 * @internal
 * @param array $eithers
 * @param string $class
 * @return array
 */
function _extract(array $eithers, string $class)
{
  return f\fold(
    function (array $acc, Monad $either) use ($class) {
      if ($either instanceof $class) {
        $acc[] = $either->isRight() ? $either->getRight() : $either->getLeft();
      }

      return $acc;
    },
    $eithers,
    []
  );
}

const isLeft = __NAMESPACE__ . '\\isLeft';

/**
 * isLeft
 * Return True if the given value is a Left-value, False otherwise.
 *
 * isLeft :: Either a b -> Bool
 * 
 * @param Either $either
 * @return boolean
 */
function isLeft(Monad $either): bool
{
  return $either->isLeft();
}

const isRight = __NAMESPACE__ . '\\isRight';

/**
 * isRight function
 * Return True if the given value is a Right-value, False otherwise.
 *
 * isRight :: Either a b -> Bool
 *
 * @param Either $either
 * @return bool
 */
function isRight(Monad $either): bool
{
  return $either->isRight();
}

const lefts = __NAMESPACE__ . '\\lefts';

/**
 * lefts function
 * Extracts from a list of Either all the Left elements.
 *
 * lefts :: [Either a b] -> [a]
 *
 * @param array $eithers
 * @return array
 */
function lefts(array $eithers): array
{
  return _extract($eithers, Left::class);
}

const rights = __NAMESPACE__ . '\\rights';

/**
 * rights function
 * Extracts from a list of Either all the Right elements.
 *
 * rights :: [Either a b] -> [b]
 *
 * @param array $eithers
 * @return array
 */
function rights(array $eithers): array
{
  return _extract($eithers, Right::class);
}

const fromRight = __NAMESPACE__ . '\\fromRight';

/**
 * fromRight function
 * Return the contents of a Right-value or a default value otherwise.
 *
 * fromRight :: b -> Either a b -> b
 *
 * @param mixed $default
 * @param Either $either
 * @return mixed
 */
function fromRight($default, Monad $either)
{
  return $either->isRight() ? $either->getRight() : $default;
}

const fromLeft = __NAMESPACE__ . '\\fromLeft';

/**
 * fromLeft function
 * Return the contents of a Left-value or a default value otherwise.
 *
 * fromLeft :: a -> Either a b -> a
 *
 * @param mixed $default
 * @param Either $either
 * @return mixed
 */
function fromLeft($default, Monad $either)
{
  return $either->isLeft() ? $either->getLeft() : $default;
}

const partitionEithers = __NAMESPACE__ . '\\partitionEithers';

/**
 * partitionEithers function
 * Partitions a list of Either into two lists.
 *
 * partitionEithers :: [Either a b] -> ([a], [b])
 *
 * @param array $eithers
 * @return array
 */
function partitionEithers(array $eithers): array
{
  return f\fold(
    function (array $acc, Monad $either) {
      if ($either->isRight()) {
        $acc['right'][] = $either->getRight();
      } else {
        $acc['left'][] = $either->getLeft();
      }

      return $acc;
    },
    $eithers,
    []
  );
}
