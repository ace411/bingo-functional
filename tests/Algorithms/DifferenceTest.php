<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class DifferenceTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [
        [\range(1, 3), \range(2, 6), \range(5, 7)],
        [1, 4, 7],
      ],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testdifferenceReturnsListContainingItemsAbsentFromIntersectionofLists($args, $res)
    {
        $difference = f\difference(...$args);

        $this->assertEquals($res, $difference);
    }
}
