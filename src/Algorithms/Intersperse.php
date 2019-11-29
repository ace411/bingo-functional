<?php

declare(strict_types=1);

/**
 *
 * intersperse function
 *
 * intersperse :: a -> [a] -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const intersperse = __NAMESPACE__ . '\\intersperse';

function intersperse($element, array $list): array
{
    $elem = array_pad([], count($list), $element);
    $res  = array_merge(...array_map(null, $list, $elem));

    return dropRight($res, 1);
}
