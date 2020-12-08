<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class ComposeTest extends \PHPUnit\Framework\TestCase
{
    public function contextProvider()
    {
        return [
      [
        [
          function ($val) {
              return $val ** 2;
          },
          function ($fst) {
              return $fst + 10;
          },
        ],
        2,
        14,
      ],
      [
        ['strtoupper', 'lcfirst', 'strrev'],
        'foo-bar',
        'RAB-OOf',
      ],
    ];
    }

    /**
     * @dataProvider contextProvider
     */
    public function testComposeCreatesMetaFunctionFromMultipleFunctions($funcs, $val, $res)
    {
        $compose = f\compose(...$funcs);

        $this->assertInstanceOf(\Closure::class, $compose);
        $this->assertEquals($res, $compose($val));
    }
}
