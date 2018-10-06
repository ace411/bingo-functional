<?php

/**
 * ListMonad helper functions.
 *
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use Chemem\Bingo\Functional\Functors\Monads\ListMonad as LMonad;
use function Chemem\Bingo\Functional\Algorithms\flatten;
use function Chemem\Bingo\Functional\Algorithms\fold;
use function Chemem\Bingo\Functional\Algorithms\head as _head;
use function Chemem\Bingo\Functional\Algorithms\last;

/**
 * fromValue function
 * Create a list from a value.
 *
 * fromValue :: a -> ListMonad [a]
 *
 * @param mixed $value
 *
 * @return object ListMonad
 */
const fromValue = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\fromValue';

function fromValue($value) : LMonad
{
    return LMonad::of($value);
}

/**
 * concat function
 * Create a large list by merging multiple lists.
 *
 * concat :: ListMonad [a] -> ListMonad [b] -> ListMonad [a, b]
 *
 * @param object ListMonad $list
 *
 * @return object ListMonad
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
 * prepend function
 * Insert the items of one list into the beginning of another.
 *
 * prepend :: ListMonad [a] -> ListMonad [b] -> ListMonad [a, b]
 *
 * @param object ListMonad $value
 * @param object ListMonad $list
 *
 * @return object ListMonad
 */
const prepend = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\prepend';

function prepend(LMonad $value, LMonad $list) : LMonad
{
    return concat($value, $list);
}

/**
 * append function
 * Add the items of one list to the end of another.
 *
 * append :: ListMonad [a] -> ListMonad [b] -> ListMonad [b, a]
 *
 * @param object ListMonad $value
 * @param object ListMonad $list
 *
 * @return object ListMonad
 */
const append = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\append';

function append(LMonad $value, LMonad $list) : LMonad
{
    return concat($list, $value);
}

/**
 * head function
 * Return the first element in a list.
 *
 * head :: ListMonad [a, b] -> a
 *
 * @param object ListMonad $list
 *
 * @return mixed $head
 */
const head = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\head';

function head(LMonad $list)
{
    return _head($list->extract());
}

/**
 * tail function
 * Return the first element in a list.
 *
 * tail :: ListMonad [a, b] -> b
 *
 * @param object ListMonad $list
 *
 * @return mixed $tail
 */
const tail = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\ListMonad\\tail';

function tail(LMonad $list)
{
    return last($list->extract());
}
