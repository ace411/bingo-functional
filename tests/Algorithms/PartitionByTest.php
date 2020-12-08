<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class PartitionByTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [\range(1, 6), 2, [[1, 2], [3, 4], [5, 6]]],
      [
        ['foo', 'bar', 'baz', 'foo-bar'],
        1,
        [['foo'], ['bar'], ['baz'], ['foo-bar']],
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
