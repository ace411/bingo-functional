<?php

/**
 *
 * slugify function
 *
 * slugify :: String -> String
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const slugify = 'Chemem\\Bingo\\Functional\\Algorithms\\slugify';

function slugify(string $string): string
{
  $slugify = compose(partial('explode', ' '), function (array $words) {
    return concat('-', ...$words);
  });

  return $slugify($string);
}
