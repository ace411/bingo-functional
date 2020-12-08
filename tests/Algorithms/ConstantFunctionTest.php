<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class ConstantFunctionTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [\range(1, 3), 1],
      [['foo', 5, 6], 'foo'],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testConstantFunctionReturnsItsFirstArgument($args, $res)
    {
        $const = f\constantFunction(...$args);

        $this->assertInstanceOf(\Closure::class, $const);
        $this->assertEquals($res, $const());
    }
}
