<?php

/**
 * Either type helper functions.
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Either;

use Chemem\Bingo\Functional\Functors\Either\Either as Etype;
use function Chemem\Bingo\Functional\Algorithms\fold;
use function Chemem\Bingo\Functional\Algorithms\identity as id;

/**
 * either function
 * Case analysis for the either type.
 *
 * either :: (a -> c) -> (b -> c) -> Either a b -> c
 *
 * @param callable $left
 * @param callable $right
 * @param object Either
 *
 * @return mixed
 */
const either = 'Chemem\\Bingo\\Functional\\Functors\\Either\\either';

function either(callable $left, callable $right, Etype $either)
{
    return $either instanceof Left ?
        $left($either->getLeft()) :
        $right($either->getRight());
}

function _extract(array $eithers, string $class)
{
    return fold(
        function (array $acc, Etype $either) use ($class) {
            if ($either instanceof $class) {
                $acc[] = $either->isRight() ? $either->getRight() : $either->getLeft();
            }

            return $acc;
        },
        $eithers,
        id([])
    );
}

/**
 * isLeft function
 * Return True if the given value is a Left-value, False otherwise.
 *
 * isLeft :: Either a b -> Bool
 *
 * @return bool
 */
const isLeft = 'Chemem\\Bingo\\Functional\\Functors\\Either\\isLeft';

function isLeft(Etype $either) : bool
{
    return $either->isLeft();
}

/**
 * isRight function
 * Return True if the given value is a Right-value, False otherwise.
 *
 * isRight :: Either a b -> Bool
 *
 * @return bool
 */
const isRight = 'Chemem\\Bingo\\Functional\\Functors\\Either\\isRight';

function isRight(Etype $either) : bool
{
    return $either->isRight();
}

/**
 * lefts function
 * Extracts from a list of Either all the Left elements.
 *
 * lefts :: [Either a b] -> [a]
 *
 * @param array $eithers
 *
 * @return array
 */
const lefts = 'Chemem\\Bingo\\Functional\\Functors\\Either\\lefts';

function lefts(array $eithers) : array
{
    return _extract($eithers, Left::class);
}

/**
 * rights function
 * Extracts from a list of Either all the Right elements.
 *
 * rights :: [Either a b] -> [b]
 *
 * @param array $eithers
 *
 * @return array
 */
const rights = 'Chemem\\Bingo\\Functional\\Functors\\Either\\rights';

function rights(array $eithers) : array
{
    return _extract($eithers, Right::class);
}

/**
 * fromRight function
 * Return the contents of a Right-value or a default value otherwise.
 *
 * fromRight :: b -> Either a b -> b
 *
 * @param mixed         $default
 * @param object Either $either
 *
 * @return mixed
 */
const fromRight = 'Chemem\\Bingo\\Functional\\Functors\\Either\\fromRight';

function fromRight($default, Etype $either)
{
    return $either->isRight() ? $either->getRight() : $default;
}

/**
 * fromLeft function
 * Return the contents of a Left-value or a default value otherwise.
 *
 * fromLeft :: a -> Either a b -> a
 *
 * @param mixed         $default
 * @param object Either $either
 *
 * @return mixed
 */
const fromLeft = 'Chemem\\Bingo\\Functional\\Functors\\Either\\fromLeft';

function fromLeft($default, $either)
{
    return $either->isLeft() ? $either->getLeft() : $default;
}

/**
 * partitionEithers function
 * Partitions a list of Either into two lists.
 *
 * partitionEithers :: [Either a b] -> ([a], [b])
 *
 * @param array $eithers
 *
 * @return array
 */
const partitionEithers = 'Chemem\\Bingo\\Functional\\Functors\\Either\\partitionEithers';

function partitionEithers(array $eithers) : array
{
    return fold(
        function (array $acc, Etype $either) {
            if ($either->isRight()) {
                $acc['right'][] = $either->getRight();
            } else {
                $acc['left'][] = $either->getLeft();
            }

            return $acc;
        },
        $eithers,
        id([])
    );
}
