<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class DropLeftTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [\range(1, 7), 3, [4, 5, 6, 7]],
      [['foo' => 'foo', 'bar' => 'bar'], 1, ['bar' => 'bar']],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testDropLeftErasesElementsFromBeginningOfList($list, $count, $res)
    {
        $dropped = f\dropLeft($list, $count);

        $this->assertEquals($res, $dropped);
        $this->assertIsArray($dropped);
    }
}
