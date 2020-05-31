<?php

/**
 * omit function.
 *
 * omit :: [a] -> b -> a[b]
 *
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const omit = 'Chemem\\Bingo\\Functional\\Algorithms\\omit';

function omit(array $collection, ...$keys): array
{
  return _fold(function ($acc, $val, $idx) use ($keys) {
		if (!in_array($idx, $keys)) {
			$acc[$idx] = $val;
		}

		return $acc;
	}, $collection, []);
}
