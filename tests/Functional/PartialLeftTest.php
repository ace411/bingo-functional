<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class PartialLeftTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        function ($fst, $snd, $thd) {
          return ($fst + $snd) / $thd;
        },
        [[12, 3], 5],
        3,
      ],
      [
        function ($fst, $snd) {
          return $fst / $snd;
        },
        [[6], 3],
        2,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testpartialCreatesPartiallyAppliedFunction($func, $args, $res)
  {
    [$fst, $snd] = $args;
    $partial     = f\partial($func, ...$fst);

    $this->assertInstanceOf(\Closure::class, $partial);
    $this->assertEquals($res, $partial($snd));
  }
}
