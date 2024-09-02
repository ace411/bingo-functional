<?php

/**
 * _match function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching\Parser;

use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\fold;
use function Chemem\Bingo\Functional\keys;
use function Chemem\Bingo\Functional\map;
use function Chemem\Bingo\Functional\size;

const _match = __NAMESPACE__ . '\\_match';

/**
 * _match
 * iteratively compares patterns against discretionary input and thence computes a resultant match
 *
 * _match :: Array -> a -> a
 *
 * @param iterable $patterns
 * @param mixed $input
 * @return mixed
 */
function _match(iterable $patterns, $input)
{
  $size   = null;
  $tokens = map(_type, $keys = keys($patterns));

  if ($iterable = \is_iterable($input)) {
    $size = size($input);
  }

  foreach ($tokens as $idx => $next) {
    // perform cons match
    if (equals($next['type'], PM_RULE_CONS) && $iterable) {
      $final = $next['tokens'][$next['token_count'] - 1];

      if (equals($final[0], PM_WILDCARD)) {
        if (equals($size, ($next['token_count'] - 1))) {
          return $patterns[($keys[$idx])](...$input);
        }
      } elseif (equals($size, $next['token_count'])) {
        return $patterns[($keys[$idx])](...$input);
      }
    }

    // perform array match
    if (equals($next['type'], PM_RULE_ARRAY) && $iterable) {
      if ($size > 0) {
        $valid   = 0;
        $args    = [];
        $lexemes = $next['tokens'];

        foreach ($lexemes as $count => $bloc) {
          if (equals($bloc[0], PM_IDENTIFIER) && isset($input[$count])) {
            $valid++;
            $args[] = $input[$count];
          }

          if (equals($bloc[1], $input[$count] ?? null)) {
            $valid++;
          }

          if (equals($bloc[0], PM_WILDCARD) && ($input[$count] ?? true)) {
            $valid++;
          }

          if (equals($bloc[0], PM_CONS) && \is_iterable($input[$count] ?? null)) {
            $consc   = size($bloc[1]);
            $inputc  = size($input[$count]);
            $final   = $bloc[1][$consc - 1];

            if (equals($final[0], PM_WILDCARD)) {
              if (equals($inputc, ($consc - 1))) {
                $valid++;
                $args = \array_merge($args, $input[$count]);
              }
            } elseif (equals($inputc, $consc)) {
              $valid++;
              $args = \array_merge($args, $input[$count]);
            }
          }
        }

        if (equals($valid, $size) && equals($valid, $next['token_count'])) {
          return $patterns[($keys[$idx])](...$args);
        }
      }
    }

    // perform string match
    if (
      (equals($next['type'], PM_RULE_STRING) && !$iterable) &&
      equals($input, $next['tokens'][0][1])
    ) {
      return $patterns[($keys[$idx])]();
    }

    // perform identifier/placeholder match
    if (equals($next['type'], PM_RULE_IDENTIFIER) && !$iterable) {
      return $patterns[($keys[$idx])]($input);
    }
  }

  return (
    $patterns['_']() ??
    throw new \Exception('Could not find match for provided input')
  );
}
