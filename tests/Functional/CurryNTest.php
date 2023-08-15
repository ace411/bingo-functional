<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class CurryNTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        function ($fst, $snd = 2) {
          return $fst ** $snd;
        },
        1,
        [2],
        4,
      ],
      [
        function ($fst, $snd, $thd = 4) {
          return ($fst + $snd) / $thd;
        },
        2,
        [4, 4],
        2,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testcurryNCreatesCurriedFunction($func, $argcount, $args, $res)
  {
    $curried  = f\curryN($argcount, $func);
    $ret      = f\fold(function ($acc, $arg) {
      return $acc($arg);
    }, $args, $curried);

    $this->assertInstanceOf(\Closure::class, $curried);
    $this->assertEquals($res, $ret);
  }
}
