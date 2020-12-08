<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class PartialRightTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [
        function ($fst, $snd, $thd) {
            return ($fst + $snd) / $thd;
        },
        [[5, 12], 3],
        3,
      ],
      [
        function ($fst, $snd) {
            return $fst / $snd;
        },
        [[3], 6],
        2,
      ],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testpartialRightCreatesPartiallyAppliedFunction($func, $args, $res)
    {
        [$fst, $snd] = $args;
        $partial     = f\partialRight($func, ...$fst);

        $this->assertInstanceOf(\Closure::class, $partial);
        $this->assertEquals($res, $partial($snd));
    }
}
