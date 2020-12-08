<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class MapDeepTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [
        function ($val) {
            return $val ** 2;
        },
        ['foo' => 2, 'bar' => \range(4, 7)],
        ['foo' => 4, 'bar' => [16, 25, 36, 49]],
      ],
      [
        f\partial(f\concat, '', 'foo-'),
        ['bar' => 'bar', ['baz', 'fooz']],
        ['bar' => 'foo-bar', ['foo-baz', 'foo-fooz']],
      ],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testmapDeepTransformsEachValueInList($func, $list, $res)
    {
        $map = f\mapDeep($func, $list);

        $this->assertEquals($res, $map);
    }
}
