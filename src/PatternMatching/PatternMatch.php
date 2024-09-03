<?php

/**
 * patternMatch function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

require_once __DIR__ . '/Parser/index.php';

use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\fold;
use function Chemem\Bingo\Functional\keys;
use function Chemem\Bingo\Functional\map;
use function Chemem\Bingo\Functional\size;

use const Chemem\Bingo\Functional\PatternMatching\Parser\_type;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_CONS;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_IDENTIFIER;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_RULE_ARRAY;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_RULE_CONS;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_RULE_IDENTIFIER;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_RULE_STRING;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_WILDCARD;

const patternMatch = __NAMESPACE__ . '\\patternMatch';

/**
 * patternMatch
 * performs elaborate selective evaluation of different data types
 *
 * patternMatch :: [(a -> b)] -> a -> b
 *
 * @param array $patterns
 * @param mixed $value
 * @return mixed
 * @example
 *
 * patternMatch([
 *  '[_, "foo"]' => fn () => strtoupper('foo'),
 *  '_' => fn () => 'undefined'
 * ], ['hello', 'foo'])
 * => 'FOO'
 */
function patternMatch(iterable $patterns, $input)
{
  $input  = \is_object($input) ? \get_class($input) : $input;
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

            if (
              (equals($final[0], PM_WILDCARD) && equals($inputc, ($consc - 1))) ||
              equals($inputc, $consc)
            ) {
              $valid++;

              $args[] = $input[$count];
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

  if (!isset($patterns['_'])) {
    throw new \Exception('Could not find match for provided input');
  }

  return $patterns['_']();
}
