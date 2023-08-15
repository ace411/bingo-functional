<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class PartitionByTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        \range(1, 6),
        2,
        [
          [0 => 1, 1 => 2],
          [2 => 3, 3 => 4],
          [4 => 5, 5 => 6],
        ],
      ],
      [
        ['foo', 'bar', 'baz', 'foo-bar'],
        1,
        [
          [0 => 'foo'],
          [1 => 'bar'],
          [2 => 'baz'],
          [3 => 'foo-bar'],
        ],
      ],
      [
        new class () {
          private $foo = 'foo';
          private $bar = 'bar';
          private $baz = 'baz';
        },
        1,
        [
          ['foo' => 'foo'],
          ['bar' => 'bar'],
          ['baz' => 'baz'],
        ],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testpartitionByCreatesPartitionSizeDefinedSubDivisions($list, $psize, $res)
  {
    $partitioned = f\partitionBy($psize, $list);

    $this->assertEquals($res, $partitioned);
  }
}
