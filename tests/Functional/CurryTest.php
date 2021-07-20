<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class CurryTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        function ($fst, $snd) {
          return $fst ** $snd;
        },
        [2, 3],
        8,
      ],
      [
        function ($fst, $snd, $thd) {
          return ($fst + $snd) / $thd;
        },
        [5, 4, 3],
        3,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testcurryCreatesCurriedFunction($func, $args, $res)
  {
    $curried  = f\curry($func);
    $ret      = f\fold(function ($acc, $arg) {
      return $acc($arg);
    }, $args, $curried);

    $this->assertInstanceOf(\Closure::class, $curried);
    $this->assertEquals($res, $ret);
  }
}
