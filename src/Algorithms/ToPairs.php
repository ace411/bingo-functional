<?php

/**
 * toPairs function.
 *
 * toPairs :: [a] -> [[b, c]]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const toPairs = 'Chemem\\Bingo\\Functional\\Algorithms\\toPairs';

function toPairs($list): array
{
  return _fold(function ($acc, $val, $idx) {
    $acc[] = [$idx, $val];

    return $acc;
  }, $list, []);
}
