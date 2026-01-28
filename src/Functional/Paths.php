<?php

/**
 * paths function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const paths = __NAMESPACE__ . '\\paths';

/**
 * paths
 * compute paths to values in a list structure
 *
 * paths :: a -> String -> (String -> String -> String -> String) -> String -> a
 *
 * @param iterable $list
 * @param string $glue
 * @param callable|null $modify
 * @param string $prefix
 * @return iterable
 * @example
 *
 * paths(['foo' => ['bar' => ['baz']], 'bar' => ['baz']])
 * => ['foo.0.bar.0' => 'baz', 'bar.0' => 'baz']
 */
function paths(
  $list,
  string $glue      = '.',
  ?callable $modify = null,
  string $prefix    = ''
): array {
  return fold(
    function ($acc, $value, $key) use ($glue, $modify, $prefix) {
      if (\is_iterable($value) || \is_countable($value)) {
        $acc = \array_merge(
          $acc,
          paths(
            $value,
            $glue,
            $modify,
            !\is_null($modify) ?
              $modify($prefix, $key, $glue) :
              \sprintf('%s%s%s', $prefix, $key, $glue)
          )
        );
      } else {
        $acc[$prefix . $key] = $value;
      }

      return $acc;
    },
    $list,
    []
  );
}
