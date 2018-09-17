<?php

namespace Chemem\Bingo\Functional\Functors\Monads\Writer;

use \Chemem\Bingo\Functional\{
    Algorithms as A,
    Functors\Monads\Writer as WriterMonad
};

/**
 * writer :: a -> String w -> WriterMonad (a, w)
 */

const writer = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\writer';

function writer($result, $output) : WriterMonad
{
    return WriterMonad::of($result, $output);
}

/**
 * runWriter :: Writer a w -> (a, w)
 */

const runWriter = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\runWriter';

function runWriter(WriterMonad $writer) : array
{
    return $writer->run();
}

/**
 * execWriter :: Writer a w -> w
 */

const execWriter = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\execWriter';

function execWriter(WriterMonad $writer)
{
    list(, $output) = $writer->run();

    return $output;
}

/**
 * mapWriter :: ((a, w) -> (b, w')) -> Writer w a -> Writer w' b
 */

const mapWriter = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\mapWriter';

function mapWriter(callable $function, WriterMonad $writer) : WriterMonad
{
    $return = A\compose(A\partialLeft(A\mapDeep, $function), 'array_reverse');

    return writer(...$return($writer->run()));
}