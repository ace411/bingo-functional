<?php

/**
 * slugify function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const slugify = __NAMESPACE__ . '\\slugify';

/**
 * slugify
 * converts a string to a slug
 *
 * slugify :: String -> String
 *
 * @param string $string
 * @return string
 * @example
 *
 * slugify('lorem ipsum')
 * => 'lorem-ipsum'
 */
function slugify(string $string): string
{
  $slugify = compose(
    partial('explode', ' '),
    function (array $words) {
      return concat('-', ...$words);
    }
  );

  return $slugify($string);
}
