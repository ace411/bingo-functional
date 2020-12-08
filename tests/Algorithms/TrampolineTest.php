<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class TrampolineTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        $fact = function ($val) use (&$fact) {
          return $val < 2 ? 1 : $val * $fact($val - 1);
        },
        15,
        1307674368000,
      ],
      [
        $fib = function ($val) use (&$fib) {
          return $val < 2 ? $val : $fib($val - 2) + $fib($val - 1);
        },
        11,
        89,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testtrampolineOptimizesRecursiveFunction($func, $arg, $res)
  {
    $rec  = f\trampoline($func);
    $perf = function ($func, ...$args) {
      $fst = \microtime(true);

      $func(...$args);

      return \microtime(true) - $fst;
    };

    $bench = f\fold(function ($log, $att) use ($rec, $perf, $arg) {
      $log[$att] = $perf($rec, $arg);

      return $log;
    }, \range(0, 4), []);

    $this->assertTrue(f\last($bench) <= f\head($bench));
    $this->assertEquals($res, $rec($arg));
  }
}
