<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class FlipTest extends \PHPunit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        function ($fst, $snd) {
          return $fst / $snd;
        },
        [2, 4],
        2,
      ],
      [
        function ($fst, $snd) {
          return f\concat(', ', $fst, $snd);
        },
        ['bar', 'foo'],
        'foo, bar',
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testflipReversesArgumentOrder($func, $args, $res)
  {
    $flip = f\flip($func);

    $this->assertInstanceOf(\Closure::class, $flip);
    $this->assertEquals($res, $flip(...$args));
  }
}
