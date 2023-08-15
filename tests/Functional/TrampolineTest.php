<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class TrampolineTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
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
    $rec = f\trampoline($func);

    $this->assertEquals($res, $rec($arg));
  }
}
