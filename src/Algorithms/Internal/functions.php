<?php

/**
 * Internal helper functions
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms\Internal;

use Chemem\Bingo\Functional\Algorithms as a;

/**
 * _count
 *
 * _count :: [a] -> Int
 *
 * @param mixed $list
 */
function _count($list)
{
    return \count(\is_array($list) ? $list : \get_object_vars($list));
}

const _count = __NAMESPACE__ . '\\count';

/**
 * _anyEvery
 *
 * _anyEvery :: (a -> Bool) -> [a] -> Bool -> Bool
 *
 * @param callable $func
 * @param mixed $list
 * @param bool $every
 */
function _anyEvery(
    callable $func,
    $list,
    bool $every = true
) {
    $listCount = _count($list);

    $filter = a\compose(
        a\partial(a\filter, $func),
        function ($res) use ($every, $listCount) {
        $resCount = _count($res);

        return $every ? $listCount == $resCount : $resCount >= 1;
    }
    );

    return $filter($list);
}

const _anyEvery = __NAMESPACE__ . '\\_anyEvery';

/**
 * _drop
 *
 * _drop :: [a, b] -> Int -> Bool -> [b]
 *
 * @param array $list
 * @param int $number
 * @param bool $left
 */
function _drop(
    array $list,
    int $number,
    bool $left = false
): array {
    $acc        = [];
    $count      = 0;
    $toIterate  = $left ? $list : \array_reverse($list);

    foreach ($toIterate as $idx => $val) {
        $count += 1;
        if ($count <= (\count($list) - $number)) {
            $acc[$idx] = $val;
        }
    }

    return $left ? $acc : \array_reverse($acc);
}

const _drop = __NAMESPACE__ . '\\_drop';

/**
 * _fold
 *
 * _fold :: (a -> b -> c -> a) -> [b] -> a -> a
 *
 * @param callable $func
 * @param mixed $list
 * @param mixed $acc
 */
function _fold(
    callable $func,
    $list,
    $acc
) {
    foreach ($list as $idx => $val) {
        $acc = $func($acc, $val, $idx);
    }

    return $acc;
}

const _fold = __NAMESPACE__ . '\\_fold';

/**
 * _partial
 *
 * _partial :: (a -> b -> c) -> [a, b] -> Bool -> (a) b
 *
 * @param callable $func
 * @param array $args
 * @param bool $left
 */
function _partial(callable $func, array $args, bool $left = true)
{
    $argCount = (new \ReflectionFunction($func))
    ->getNumberOfRequiredParameters();

    $acc      = function (...$inner) use (&$acc, $func, $argCount, $left) {
        return function (...$innermost) use (
      $inner,
      $acc,
      $func,
      $left,
      $argCount
    ) {
            $final = $left ?
        \array_merge($inner, $innermost) :
        \array_merge(\array_reverse($innermost), \array_reverse($inner));

            if ($argCount <= \count($final)) {
                return $func(...$final);
            }

            return $acc(...$final);
        };
    };

    return $acc(...$args);
}

const _partial = __NAMESPACE__ . '\\_partial';
