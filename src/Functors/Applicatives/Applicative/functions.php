<?php

/**
 * Applicative helper functions.
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicatives\Applicative;

use Chemem\Bingo\Functional\Functors\Applicatives\Applicative as App;

/**
 * pure function
 * Lifts a value.
 *
 * pure :: a -> f a
 *
 * @param mixed $value
 *
 * @return object Applicative
 */

const pure = 'Chemem\\Bingo\\Functional\\Functors\\Applicatives\\Applicative\\pure';

function pure($value): App
{
    return App::pure($value);
}

/**
 * liftA2 function
 * Lift a binary function to actions.
 *
 * liftA2 :: (a -> b -> c) -> f a -> f b -> f c
 *
 * @param callable           $function
 * @param object Applicative $values
 *
 * @return object Applicative
 */
const liftA2 = 'Chemem\\Bingo\\Functional\\Functors\\Applicatives\\Applicative\\liftA2';

function liftA2(callable $function, App ...$values): App
{
    $args = \array_map(
        function (App $val) {
            return $val->getValue();
        },
        $values
    );

    return pure(\call_user_func_array($function, $args));
}
