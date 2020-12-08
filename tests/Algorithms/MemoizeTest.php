<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class MemoizeTest extends \PHPUnit\Framework\TestCase
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
    public function testmemoizeCachesFunction($func, $arg, $res)
    {
        $memoized = f\memoize($func);

        $time = function ($func, ...$args) {
            $fst = \microtime(true);

            $func(...$args);

            return \microtime(true) - $fst;
        };

        // run the function five times and log the performance of
        $bench = f\fold(function ($log, $attempt) use ($memoized, $time, $arg) {
            $log[$attempt] = $time($memoized, $arg);

            return $log;
        }, \range(0, 4), []);

        // check if last time < first time
        $this->assertTrue(f\last($bench) <= f\head($bench));
    
        // check if memoize computes the function
        $this->assertEquals($res, $memoized($arg));
    }
}
