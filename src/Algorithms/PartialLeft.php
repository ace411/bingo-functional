<?php

/**
 * PartialLeft function.
 *
 * partialLeft :: (a, b) -> (a) b
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_partial;

const partialLeft = 'Chemem\\Bingo\\Functional\\Algorithms\\partialLeft';

function partialLeft(callable $func, ...$args)
{
    return _partial($func, $args);
}

const partial = 'Chemem\\Bingo\\Functional\\Algorithms\\partial';

function partial(callable $func, ...$args)
{
    return partialLeft($func, ...$args);
}

