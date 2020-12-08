<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class MeanTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [(object) \range(1, 7), 4],
      [['foo' => 0, 12, 3], 5],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testmeanComputesTheAverageOfItemsInAList($list, $avg)
    {
        $mean = f\mean($list);

        $this->assertEquals($avg, $mean);
        $this->assertTrue(
            \is_int($mean) || \is_double($mean) || \is_float($mean)
        );
    }
}
