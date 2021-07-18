<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class ComposeRightTest extends \PHPUnit\Framework\TestCase
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
        144,
      ],
      [
        ['lcfirst', 'strtoupper', 'strrev'],
        'foo-bar',
        'rAB-OOF',
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testcomposeRightComposesFunctionsFromRIghtToLeft($funcs, $val, $res)
  {
    $compose = f\composeRight(...$funcs);

    $this->assertInstanceOf(\Closure::class, $compose);
    $this->assertEquals($res, $compose($val));
  }
}
