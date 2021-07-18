<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class MapTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        function ($val) {
          return $val ** 2;
        },
        ['foo' => 2, 'bar' => 4],
        ['foo' => 4, 'bar' => 16],
      ],
      [
        f\partial(f\concat, '', 'foo-'),
        (object) ['bar' => 'bar', 'baz'],
        (object) ['bar' => 'foo-bar', 'foo-baz'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testmapTransformsEachValueInList($func, $list, $res)
  {
    $map = f\map($func, $list);

    $this->assertEquals($res, $map);
  }
}
