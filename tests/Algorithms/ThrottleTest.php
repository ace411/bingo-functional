<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class ThrottleTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        function ($fst, $snd) {
          return $fst + $snd;
        },
        2,
        [3, 5],
        8,
      ],
      [
        function ($val) {
          return $val ** 2;
        },
        4,
        [4],
        16,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testThrottleDefersFunctionExecutionBySpecifiedTimeoutDuration($func, $timeout, $args, $res)
  {
    $timer = function () use ($timeout, $func, $args) {
      $begin = \microtime(true);

      $res = f\throttle($func, $timeout)(...$args);

      return [$res, \microtime(true) - $begin];
    };

    [$return, $diff] = $timer();

    // account for execution semantics and specified timeout
    $this->assertTrue($diff >= $timeout);

    $this->assertEquals($res, $return);
  }
}
