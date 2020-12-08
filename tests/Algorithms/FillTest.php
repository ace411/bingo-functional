<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class FillTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [\range(1, 4), 'foo', [1, 2], [1, 'foo', 'foo', 4]],
      [
        (object) ['foo', 2, 'bar', 'baz'],
        3,
        [2, 3],
        (object) ['foo', 2, 3, 3],
      ],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testfillReplacesValuesInSpecifiedIndexRangeWithArbitraryValue($list, $val, $range, $res)
    {
        $assoc = f\fill($list, $val, ...$range);

        $this->assertEquals($res, $assoc);
    }
}
