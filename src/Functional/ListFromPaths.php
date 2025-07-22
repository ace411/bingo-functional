<?php

/**
 * listFromPaths function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_ClonePath.php';

use function Chemem\Bingo\Functional\Internal\_clonePath;

const listFromPaths = __NAMESPACE__ . '\\listFromPaths';

/**
 * listFromPaths
 * creates a list from another one that contains paths and the values associated with them
 *
 * listFromPaths :: Sum Array Object -> Sum Array Object
 *
 * @param array|object $list
 * @param string $separator
 * @return array|object
 * @example
 *
 * listFromPaths((object) ['foo.bar' => 12, 'foo.baz.qux' => 'foo'])
 * => ['foo' => ['bar' => 12, 'baz' => ['qux' => 'foo']]]
 */
function listFromPaths($list, string $separator = '.')
{
  return fold(
    function (
      $acc,
      $value,
      string $path
    ) use ($separator) {
      $acc = _clonePath(
        $acc,
        $path,
        $value,
        $separator
      );

      return $acc;
    },
    $list,
    []
  );
}
