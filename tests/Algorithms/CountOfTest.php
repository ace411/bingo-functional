<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class CountOfTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [
        [
          'foo' => [
            'bar' => ['foo', 'fooz'],
            'baz' => 2,
          ],
          'bar' => 'fooz',
        ],
        ['fooz', '2'],
        [2, 1],
      ],
      [
        [
          'foo' => 3,
          'baz' => (object) [
            'foo' => [3, 'fooz'],
          ],
        ],
        ['fooz', 'foo'],
        [1, 2],
      ],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testcountOfValueComputesFrequencyOfSpecifiedListValue($list, $search, $res)
    {
        [$value,] = $search;
        [$ret,]   = $res;

        $count = f\countOfValue($list, $value);

        $this->assertEquals($ret, $count);
    }

    /**
     * @dataProvider contextProvider
     */
    public function testcountOfKeyComputesFrequencyOfSpecifiedListKey()
    {
        [, $key] = $search;
        [, $ret] = $res;

        $count = f\countOfKey($list, $key);

        $this->assertEquals($ret, $count);
    }
}
