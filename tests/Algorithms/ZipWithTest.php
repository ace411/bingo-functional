<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class ZipWithTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [
        function ($int, $str) {
            return $int + \mb_strlen($str, 'utf-8');
        },
        [\range(1, 3), ['foo', 'bar', 'baz']],
        \range(4, 6),
      ],
      [
        f\partial(f\concat, ', '),
        [['foo', 'bar'], ['fooz', 'baz']],
        ['foo, fooz', 'bar, baz'],
      ],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testzipWithZipsListInAccordanceWithFunctionRubric($func, $lists, $res)
    {
        $zipped = f\zipWith($func, ...$lists);

        $this->assertEquals($res, $zipped);
    }
}
