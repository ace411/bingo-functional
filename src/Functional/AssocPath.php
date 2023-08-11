<?php

/**
 * assocPath
 *
 * @see https://ramdajs.com/docs/#assocPath
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_JsonPath.php';
require_once __DIR__ . '/Internal/_MergeN.php';

use function Chemem\Bingo\Functional\Internal\_jsonPath;
use function Chemem\Bingo\Functional\Internal\_mergeN;

const assocPath = __NAMESPACE__ . '\\assocPath';

/**
 * assocPath
 * creates a shallow clone of a list with an overwritten value assigned to the index at the end of a traversable path
 *
 * assocPath :: [a] -> b -> [b] -> [b]
 *
 * @param array|string $path
 * @param mixed $val
 * @param array|object $list
 * @return array|object
 * @example
 *
 * assocPath(['x', 1], 'foo', ['x' => range(1, 3)])
 * => ['x' => [1, 'foo', 3]]
 */
function assocPath($path, $val, $list)
{
  $path = _jsonPath($path);

  if (!\is_null(pluckPath($path, $list))) {
    $pathc = size($path);

    if (equals($pathc, 0)) {
      return $list;
    }

    $idx = head($path);

    if ($pathc > 1) {
      $next = pluck($list, $idx);

      if (\is_object($next) || \is_array($next)) {
        $val = assocPath(dropLeft($path), $val, $next);
      }
    }

    return assoc($idx, $val, $list);
  } else {
    $listc  = size($list);
    $lcheck = pluckPath(dropRight($path, 1), $list);
    $clone  = function ($path, $val, $list) use (
      &$clone,
      $listc,
      $lcheck
    ) {
      return fold(
        function ($acc, $entry) use (
          &$clone,
          $lcheck,
          $list,
          $listc,
          $path,
          $val
        ) {
          if (equals(size($acc), 1)) {
            // preempt extraneous list concatenation
            return $acc;
          }

          if (equals(size($path), 1)) {
            // check if the key exists
            if (!\is_null($lcheck)) {
              if (\is_array($lcheck)) {
                $lcheck[$entry] = $val;
              } elseif (\is_object($lcheck)) {
                $lcheck->{$entry} = $val;
              }

              $acc = (array) $lcheck;
            } else {
              $acc[$entry] = $val;
            }

            $acc[$entry] = $val;
          } else {
            $acc[$entry] = $clone(dropLeft($path), $val, $list);
          }

          return $acc;
        },
        $path,
        []
      );
    };

    $result = $clone($path, $val, $list);

    return _mergeN($list, $result);
  }

  return $list;
}
