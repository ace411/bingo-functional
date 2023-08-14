<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class IndexesOfTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        ['foo' => 'foo', 'bar' => ['baz' => 12]],
        12,
        ['baz'],
      ],
      [(object) \range(1, 4), 2, [1]],
      [(object) ['foo', 'bar' => ['bar']], 'baz', []],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testIndexesOfReturnsIndexAssociatedWithSpecifiedValue($list, $val, $res)
  {
    $index = f\indexesOf($list, $val);

    $this->assertEquals($res, $index);
  }
}
