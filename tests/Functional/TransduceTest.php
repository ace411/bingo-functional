<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Transducer as t;

class TransduceTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        f\flip(f\compose)(
          t\map(function (int $x) {
            return $x + 3;
          }),
          t\map(function (int $x) {
            return $x ** 2;
          }),
          t\filter(function (int $x) {
            return $x % 2 === 0;
          })
        ),
        function ($acc, $val, $idx) {
          return f\extend($acc, [$idx => $val]);
        },
        [
          'foo' => 1,
          'bar' => 3,
          'baz' => 4,
        ],
        [],
        ['foo' => 16, 'bar' => 36],
      ],
      [
        f\flip(f\compose)(
          t\map('strtoupper'),
          t\reject(function (string $str) {
            return (
              \function_exists('mb_strlen') ?
                \mb_strlen($val, 'utf-8') :
                \strlen($val)
            ) > 3;
          }),
          t\map(function (string $str) {
            return f\concat('-', ...\str_split($str));
          })
        ),
        function ($acc, $val, $idx) {
          return f\extend($acc, [$idx => $val]);
        },
        ['foo', 'bar', 'baz', 'foo-bar'],
        [],
        ['F-O-O', 'B-A-R', 'B-A-Z'],
      ],
      [
        f\composeRight(
          t\map(function (int $x) {
            return $x ** 2;
          }),
          t\reject(function (int $x) {
            return $x > 20;
          })
        ),
        function ($acc, $val) {
          return $acc + $val;
        },
        [3, 7, 1, 9],
        0,
        10,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testtransduceEffectivelyPipelinesListOperations($transducer, $step, $list, $acc, $res)
  {
    $transduced = f\transduce($transducer, $step, $list, $acc);

    $this->assertEquals($res, $transduced);
  }
}
