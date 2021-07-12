<?php

/**
 * difference function
 *
 * @see https://lodash.com/docs/4.17.11#difference
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const difference = __NAMESPACE__ . '\\difference';

/**
 * difference
 * compares lists and returns elements absent from their intersection
 *
 * difference :: Eq a => [a] -> [a] -> [a]
 *
 * @param array ...$array
 * @return array
 * @example
 *
 * difference(['foo', 'bar'], ['foo', 'baz'], ['fooz', 'boo'])
 * //=> ['bar', 'baz', 'fooz', 'boo']
 */
function difference(array ...$array): array
{
  $ret = compose(flatten, function (array $data) {
    return fold(function ($res, $val) use ($data) {
      if (countOfValue($data, $val) < 2) {
        $res[] = $val;
      }

      return $res;
    }, $data, []);
  });

  return $ret($array);
}
