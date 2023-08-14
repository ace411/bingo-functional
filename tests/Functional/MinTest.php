<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class MinTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [[1, 9, 12.2, 3], 1],
      [(object) [3, 1, 9], 1],
      [(object) ['foo', 'bar', 'baz'], 0],
      [['foo', -3, 'baz'], -3],
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
