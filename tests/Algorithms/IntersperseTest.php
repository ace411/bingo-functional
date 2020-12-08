<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class IntersperseTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [\range(1, 4), 'foo', [1, 'foo', 2, 'foo', 3, 'foo', 4]],
      [['foo', 'bar'], 2, ['foo', 2, 'bar']],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testintersperseCreatesListWithArbitraryValueInterposedBetweenElements($list, $val, $res)
  {
    $interspersed = f\intersperse($val, $list);

    $this->assertEquals($res, $interspersed);
  }
}