<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class IntersperseTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [\range(1, 4), 'foo', [1, 'foo', 2, 'foo', 3, 'foo', 4]],
      [['foo', 'bar'], 2, ['foo', 2, 'bar']],
      [
        (object) [
          'foo' => 3.332,
          'bar' => 'quux',
          'baz' => null,
        ],
        false,
        [
          'foo' => 3.332,
          '0'   => false,
          'bar' => 'quux',
          '1'   => false,
          'baz' => null,
        ],
      ],
      [
        (object) [
          false,
          null,
          \range(1, 3),
        ],
        'qux',
        [
          false,
          'qux',
          null,
          'qux',
          \range(1, 3),
        ],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testintersperseCreatesListWithArbitraryValueInterposedBetweenElements($list, $val, $res)
  {
    $interspersed = f\intersperse($val, $list);

    $this->assertEquals($res, $interspersed);
  }
}
