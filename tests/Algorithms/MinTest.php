<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class MinTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [[1, 9, 12.2, 3], 1],
      [(object) [3, 1, 9], 1],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testminComputesLowestValueInList($list, $res)
  {
    $min = f\min($list);

    $this->assertEquals($res, $min);
    $this->assertTrue(
      \is_int($min) || \is_double($min) || \is_float($min)
    );
  }
}
