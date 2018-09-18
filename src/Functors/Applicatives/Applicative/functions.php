<?php

namespace Chemem\Bingo\Functional\Functors\Applicatives\Applicative;

use \Chemem\Bingo\Functional\Functors\Applicatives\Applicative as App;

/**
 * pure :: a -> f a
 */

const pure = 'Chemem\\Bingo\\Functional\\Functors\\Applicatives\\Applicative\\pure';

function pure($value) : App
{
    return App::pure($value);
}

/**
 * liftA2 :: (a -> b -> c) -> f a -> f b -> f c 
 */

const liftA2 = 'Chemem\\Bingo\\Functional\\Functors\\Applicatives\\Applicative\\liftA2';

function liftA2(callable $function, App ...$values) : App
{
    $result = array_map(
        function (App $value) use ($function) { 
            return pure($function)
                ->ap($value); 
        },
        $values
    );

    return pure($result);
}
