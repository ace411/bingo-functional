<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class MaxTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [[1, 9, 12.2, 3], 12.2],
      [(object) ['foo', 'bar', 'baz'], 0],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testmaxComputesLargestValueInList($list, $res)
  {
    $max = f\max($list);

    $this->assertEquals($res, $max);
    $this->assertTrue(
      \is_int($max) || \is_double($max) || \is_float($max)
    );
  }
}
