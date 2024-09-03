<?php

/**
 * cmatch function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

require_once __DIR__ . '/Parser/index.php';

use function Chemem\Bingo\Functional\PatternMatching\Parser\_tokenize;
use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\size;

use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_RULE_CONS;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_WILDCARD;

/**
 * cmatch
 * selectively evaluates cons-evaluable data
 *
 * cmatch :: [([a] -> b)] -> [a] -> b
 *
 * @param array $patterns
 * @return callable
 * @example
 *
 * cmatch([
 *  '(x:_)' => fn ($x) => $x + 10,
 *  '_' => fn () => 0,
 * ])([2])
 * => 12
 */
function cmatch(iterable $patterns): callable
{
  return function (iterable $values) use ($patterns) {
    $size = size($values);

    foreach ($patterns as $pattern => $action) {
      if (\preg_match('/^(\(){1}(.*)(\:\_)?(\)){1}$/ix', $pattern, $matches)) {
        $ptt = isset($matches[2]) ? $matches[2] : [];

        if (!empty($ptt)) {
          $next  = _tokenize($ptt, PM_RULE_CONS);
          $final = $next['tokens'][$next['token_count'] - 1];

          // non-strict cons match
          if (equals($final[0], PM_WILDCARD)) {
            if (equals($size, ($next['token_count'] - 1))) {
              return $action(...$values);
            }
          } elseif (equals($size, $next['token_count'])) {
            return $action(...$values);
          }
        }
      }
    }

    if (!isset($patterns['_'])) {
      throw new \Exception('Could not find match for provided input');
    }

    return $patterns['_']();
  };
}
