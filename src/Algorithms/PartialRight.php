<?php

/**
 * PartialRight function.
 *
 * partialRight :: (a, b) -> (b) a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_partial;

const partialRight = 'Chemem\\Bingo\\Functional\\Algorithms\\partialRight';

function partialRight(callable $func, ...$args)
{
    return _partial($func, $args, false);
}
