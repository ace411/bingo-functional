<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class PluckTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      ['x', ['x' => 2], null,  2],
      [1, (object) [3, ['foo' => 'baz']], 'undefined', ['foo' => 'baz']],
      [5, \range(1, 3), 0, 0],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testpluckReturnsValueAssociatedWithSpecifiedKey($key, $list, $def, $res)
    {
        $pluck = f\pluck($list, $key, $def);

        $this->assertEquals($res, $pluck);
    }
}
