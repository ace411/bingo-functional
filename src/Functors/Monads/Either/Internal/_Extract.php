<?php

/**
 * _extract
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Either\Internal;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\fold;

const _extract = __NAMESPACE__ . '\\_extract';

/**
 * _extract
 * extracts one of either Right or Left types
 *
 * @internal
 * @param array|object $eithers
 * @param string $class
 * @return array
 */
function _extract($eithers, string $class)
{
  return fold(
    function (array $acc, Monad $either) use ($class) {
      if ($either instanceof $class) {
        $acc[] = $either->isRight() ?
          $either->getRight() :
          $either->getLeft();
      }

      return $acc;
    },
    $eithers,
    []
  );
}
