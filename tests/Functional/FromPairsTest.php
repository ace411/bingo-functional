<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class FromPairsTest extends \PHPunit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        [['foo', 'bar'], ['baz', 'fooz']],
        [
          'foo' => 'bar',
          'baz' => 'fooz',
        ],
      ],
      [
        [[2, 4], [0, 'foo']],
        [2 => 4, 0 => 'foo'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testfromPairsConstructsAssociativeArrayFromArrayPairs($list, $res)
  {
    $assoc = f\fromPairs($list);

    $this->assertEquals($res, $assoc);
  }
}
