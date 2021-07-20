<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class PartitionTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [\range(1, 6), 2, [[1, 2, 3], [4, 5, 6]]],
      [
        ['foo', 'bar', 'baz', 'foo-bar'],
        1,
        [['foo', 'bar', 'baz', 'foo-bar']],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testpartitionCreatesPartitionCountDefinedSubDivisions($list, $pcount, $res)
  {
    $partitioned = f\partition($pcount, $list);

    $this->assertEquals($res, $partitioned);
  }
}
