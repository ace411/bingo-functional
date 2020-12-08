<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class ToPairsTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        ['foo' => 'foo', 'bar' => 'bar'],
        [['foo', 'foo'], ['bar', 'bar']],
      ],
      [
        \range(1, 3),
        [[0, 1], [1, 2], [2, 3]],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testtoPairsCreatesArrayPairsFromList($list, $res)
  {
    $pairs = f\toPairs($list);

    $this->assertEquals($res, $pairs);
  }
}
