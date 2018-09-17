<?php

namespace Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use \Chemem\Bingo\Functional\Functors\Monads\ListMonad as LMonad;
use function \Chemem\Bingo\Functional\Algorithms\{fold, extend, last, head as _head};

/**
 * fromValue :: a -> ListMonad [a]
 */

const fromValue = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\fromValue';

function fromValue($value) : LMonad
{
    return LMonad::of($value);
}

/**
 * concat :: ListMonad [a] -> ListMonad [b] -> ListMonad [a, b]
 */

const concat = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\concat';

function concat(LMonad ...$list) : LMonad
{
    $res = fold(
        function (array $return, LMonad $list) {
            $return[] = $list->extract();

            return $return;
        }, 
        $list, 
        []
    );

    return fromValue(flatten($res));
}

/**
 * prepend :: ListMonad [a] -> ListMonad [b] -> ListMonad [a, b]
 */

const prepend = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\prepend';

function prepend(LMonad $value, LMonad $list) : LMonad
{
    return $list->map(function ($list) use ($value) {
        return extend($value->extract(), $list);
    });
}

/**
 * append :: ListMonad [a] -> ListMonad [b] -> ListMonad [b, a]
 */

const append = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\append';

function append(LMonad $value, LMonad $list) : LMonad
{
    return $list->map(function ($list) use ($value) {
        return extend($list, $value->extract());
    });
}

/**
 * head :: ListMonad [a, b] -> a 
 */

const head = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\head';

function head(LMonad $list)
{
    return _head($list->extract());
}

/**
 * tail :: ListMonad [a, b] -> b
 */

const tail = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\tail';

function tail(LMonad $list)
{
    return last($list->extract());
}
