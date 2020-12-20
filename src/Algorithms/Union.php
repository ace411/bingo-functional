<?php

/**
 *
 * union function
 *
 * union :: [a] -> [b] -> [a, b]
 *
 * @see https://lodash.com/docs/4.17.11#union
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const union = 'Chemem\\Bingo\\Functional\\Algorithms\\union';

function union(array ...$values): array
{
  $res = compose(flatten, unique);

  return $res($values);
}
