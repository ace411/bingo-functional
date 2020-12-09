<?php

/**
 * Head function.
 *
 * head :: [a, b] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const head = 'Chemem\\Bingo\\Functional\\Algorithms\\head';

function head($list)
{
  return \reset($list);
}
