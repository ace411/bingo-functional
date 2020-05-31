<?php

/**
 * Pick function.
 *
 * pick :: [a] -> b -> b
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const pick = 'Chemem\\Bingo\\Functional\\Algorithms\\pick';

function pick($values, $search, $default = null)
{
  return _fold(function ($acc, $val) use ($search) {
		if ($search == $val) {
			$acc = $val;
		}

		return $acc;
	}, $values, $default);
}
