<?php

/**
 * extract function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

declare(strict_types=1);

namespace Chemem\Bingo\Functional\PatternMatching;

require_once __DIR__ . '/Parser/index.php';

use function Chemem\Bingo\Functional\equals;
use function Chemem\Bingo\Functional\dropLeft;
use function Chemem\Bingo\Functional\size;
use function Chemem\Bingo\Functional\PatternMatching\Parser\_type;

use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_CONS;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_IDENTIFIER;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_RULE_ARRAY;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_RULE_CONS;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_RULE_IDENTIFIER;
use const Chemem\Bingo\Functional\PatternMatching\Parser\PM_WILDCARD;

/**
 * extract
 * effects pattern-based destructuring
 *
 * extract :: String -> a -> Array
 *
 * @param string $pattern
 * @param mixed $values
 * @return iterable
 *
 * extract(
 *   '["foo", _, (x:xs:_)]',
 *   [
 *     'foo',
 *     null,
 *     \range(1, 3),
 *   ],
 * );
 * => ['x' => 1, 'xs' => [2, 3]]
 */
function extract(string $pattern, $values): iterable
{
  $size    = null;
  $tokens  = _type($pattern);
  $xargs   = [];

  if ($iterable = \is_iterable($values)) {
    $size = size($values);
  }

  if (equals($tokens['type'], PM_RULE_CONS) && $iterable) {
    $limit = $tokens['token_count'] - 1;
    $final = $tokens['tokens'][$limit];
    $idx   = -1;

    if (equals($final[0], PM_WILDCARD)) {
      while ($idx++ < ($limit - 1)) {
        $xargs[$tokens['tokens'][$idx][1]] = $values[$idx];
      }
    } else {
      while ($idx++ < $size) {
        if ($idx < $limit) {
          $xargs[$tokens['tokens'][$idx][1]] = $values[$idx];
        } else {
          $xargs[$tokens['tokens'][$idx][1]] = dropLeft($values, $limit);

          return $xargs;
        }
      }
    }

    return $xargs;
  }

  if (equals($tokens['type'], PM_RULE_ARRAY) && $iterable) {
    if ($size > 0) {
      $valid    = 0;
      $elements = $tokens['tokens'];
      $idx      = -1;

      while ($idx++ < $tokens['token_count'] - 1) {
        $bloc = $elements[$idx];

        if (equals($bloc[0], PM_IDENTIFIER) && isset($values[$idx])) {
          $valid++;

          $xargs[$bloc[1]] = $values[$idx];
        }

        if (equals($bloc[1], $values[$idx] ?? null)) {
          $valid++;
        }

        if (equals($bloc[0], PM_WILDCARD) && ($values[$idx] ?? true)) {
          $valid++;
        }

        if (equals($bloc[0], PM_CONS) && \is_iterable($values[$idx] ?? null)) {
          $pttn   = '';
          $consc  = size($bloc[1]);
          $inputc = size($values[$idx]);

          foreach ($bloc[1] as $count => $item) {
            if ($count > 0 && ($count < ($consc - 1))) {
              $pttn .= \sprintf('%s:', $item[1]);
            } elseif (equals($count, 0)) {
              $pttn .= \sprintf('(%s:', $item[1]);
            } else {
              $pttn .= \sprintf('%s)', $item[1]);
            }
          }

          if (!empty($pttn)) {
            $xargs = \array_merge($xargs, extract($pttn, $values[$idx]));
          }

          if (
            equals($bloc[1][$consc - 1][0], PM_WILDCARD) ||
            equals($inputc, $consc)
          ) {
            $valid++;
          }
        }
      }

      if (equals($valid, $size) && equals($valid, $tokens['token_count'])) {
        return $xargs;
      }
    }
  }

  if (equals($tokens['type'], PM_RULE_IDENTIFIER)) {
    $xargs[$tokens['tokens'][0][1]] = $values;
  }

  return $xargs;
}
