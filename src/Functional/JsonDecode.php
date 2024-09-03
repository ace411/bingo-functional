<?php

/**
 * jsonDecode function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

declare(strict_types=1);

namespace Chemem\Bingo\Functional;

/**
 * jsonDecode
 */
function jsonDecode(...$args)
{
  $decoder = \extension_loaded('simdjson') ?
    '\simdjson_decode' :
    '\json_decode';
  $initial = $decoder(...$args);
  $options = tail($args);

  return fold(
    function ($acc, $value, $key) use ($decoder, $options) {
      if (
        (\is_string($value) && contains($value, '\\"')) ||
        \is_iterable($value) ||
        \is_object($value)
      ) {
        if (\is_iterable($acc)) {
          $acc[$key] = jsonDecode($value, ...$options);
        } elseif (\is_object($acc)) {
          $acc->{$key} = jsonDecode($value, ...$options);
        }
      } else {
        if (\is_iterable($acc)) {
          $acc[$key] = $decoder(
            \sprintf('%s', $value),
            ...$options
          ) ?? $value;
        } elseif (\is_object($acc)) {
          $acc->{$key} = $decoder(
            \sprintf('%s', $value),
            ...$options
          ) ?? $value;
        }
      }

      return $acc;
    },
    $initial,
    \is_iterable($initial) ? [] : new \stdClass()
  );
}
