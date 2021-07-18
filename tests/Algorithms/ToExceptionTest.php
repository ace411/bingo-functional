<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class ToExceptionTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        function ($fst, $snd) {
          if ($snd == 0) {
            throw new \Exception('division by zero error');
          }

          return $fst / $snd;
        },
        function ($_) {
          return 'INF';
        },
        [3, 0],
        'INF',
      ],
      [
        function ($fst) {
          if ($fst < 10) {
            throw new \Error('less than 10');
          }

          return $fst ** 2;
        },
        null,
        [2],
        'less than 10',
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testtoExceptionAllowsForFunctionControlledErrorHandling($func, $handler, $args, $res)
  {
    $ret = f\toException($func, $handler);

    $this->assertInstanceOf(\Closure::class, $ret);
    $this->assertEquals($res, $ret(...$args));
  }
}
