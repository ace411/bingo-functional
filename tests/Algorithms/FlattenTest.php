<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class FlattenTest extends \PHPunit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        [\range(1, 3), 'foo', ['bar', [9]]],
        [1, 2, 3, 'foo', 'bar', 9],
      ],
      [
        [['bar', 'baz', [3]], 'foo'],
        ['bar', 'baz', 3, 'foo'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testflattenReducesArrayDimensionalityToOne($list, $res)
  {
    $flat = f\flatten($list);

    $this->assertIsArray($flat);
    $this->assertEquals($res, $flat);
  }
}
