<?php

/**
 * _partial function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Fold.php';

const _partial = __NAMESPACE__ . '\\_partial';

/**
 * _partial
 * template for partial* functions
 *
 * _partial :: (a -> b -> c) -> [a, b] -> Bool -> (a) b
 *
 * @internal
 * @param callable $func
 * @param array $args
 * @param bool $left
 * @return calllable
 */
function _partial(
  callable $func,
  array $args,
  bool $left = true
): callable {
  $argCount = (new \ReflectionFunction($func))
    ->getNumberOfRequiredParameters();
  $merge    = function (...$item): array {
    return _fold(
      function (array $acc, $value) {
        if (\is_array($value)) {
          foreach ($value as $entry) {
            $acc['size'] += 1;
            $acc['acc'][] = $entry;
          }
        }

        return $acc;
      },
      $item,
      [
        'size'  => 0,
        'acc'   => [],
      ]
    );
  };
  $acc      = function (...$inner) use (
    &$acc,
    $func,
    $argCount,
    $left,
    $merge
  ): callable {
    return function (...$innermost) use (
      $inner,
      $acc,
      $func,
      $left,
      $argCount,
      $merge
    ) {
      [
        'size'  => $size,
        'acc'   => $final
      ] = $merge(
        false,
        $left ?
          $inner :
          \array_reverse($innermost),
        $left ?
          $innermost :
          \array_reverse($inner)
      );

      if ($argCount <= $size) {
        return $func(...$final);
      }

      return $acc(...$final);
    };
  };

  return $acc(...$args);
}
