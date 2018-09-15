<?php

namespace Chemem\Bingo\Functional\Functors\Monads\Writer;

use \Chemem\Bingo\Functional\Functors\Monads\Writer as WriterMonad;
use function \Chemem\Bingo\Functional\Algorithms\{compose, partialLeft};

/**
 * writer :: a -> String w -> WriterMonad (a, w)
 */

const writer = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\writer';

function writer($init, string $msg) : WriterMonad
{
    return WriterMonad::of($init, $msg);
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
    $return = compose(partialLeft('array_map', $function), 'array_reverse');

    return writer(...$return($writer->run()));
}