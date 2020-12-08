<?php

/**
 * Writer monad helper functions.
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Writer-Lazy.html#g:2
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Writer;

use Chemem\Bingo\Functional\Algorithms as A;
use Chemem\Bingo\Functional\Functors\Monads\Writer as WriterMonad;

/**
 * writer function
 * Create a new instance of the writer monad.
 *
 * writer :: a -> w -> Writer (a, w)
 *
 * @param mixed $result
 * @param mixed $output
 *
 * @return object Writer
 */

const writer = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\writer';

function writer($result, $output = null): WriterMonad
{
    return WriterMonad::of($result, $output);
}

/**
 * runWriter function
 * Unwrap a writer computation as a (result, output) pair.
 *
 * runWriter :: Writer a w -> (a, w)
 *
 * @param object Writer $writer
 *
 * @return array
 */
const runWriter = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\runWriter';

function runWriter(WriterMonad $writer): array
{
    return $writer->run();
}

/**
 * tell function
 * A function that produces a Writer monad's output
 *
 * tell :: w -> m ()
 *
 * @param mixed $msg
 *
 * @return object Writer
 */

const tell = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\tell';

function tell($msg): WriterMonad
{
    return new WriterMonad(function () use ($msg) {
        return [null, [$msg]];
    });
}

/**
 * execWriter function
 * Extract the output from a writer computation.
 *
 * execWriter :: Writer a w -> w
 *
 * @param object Writer $writer
 *
 * @return array $output
 */
const execWriter = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\execWriter';

function execWriter(WriterMonad $writer)
{
    list(, $output) = $writer->run();

    return $output;
}

/**
 * mapWriter function
 * Map both the return value and output of a computation using the given function.
 *
 * mapWriter :: ((a, w) -> (b, w')) -> Writer w a -> Writer w' b
 *
 * @param callable $function
 * @param object Writer
 *
 * @return object Writer
 */
const mapWriter = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer\\mapWriter';

function mapWriter(callable $function, WriterMonad $writer): WriterMonad
{
    list($result, $output) = $function(runWriter($writer));

    return writer($result, $output);
}
