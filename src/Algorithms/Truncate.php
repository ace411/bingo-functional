<?php

/**
 *
 * truncate function
 *
 * truncate :: String -> Int -> String
 *
 * @see https://lodash.com/docs/4.17.11#truncate
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const truncate = 'Chemem\\Bingo\\Functional\\Algorithms\\truncate';

function truncate(string $string, int $limit): string
{
    $strlen = 0;
    $strlen += !function_exists('mb_strlen') ?
        strlen($string) :
        mb_strlen($string, 'utf-8');

    $truncate = compose(
        partialRight('substr', $limit, 0),
        partialRight(partial(concat, '..'), '.')
    );

    return $limit > $strlen ? $string : $truncate($string);
}
