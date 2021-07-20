<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class IntersectsTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [[\range(1, 5), \range(3, 9)], true],
      [[(object) ['foo' => 'foo'], (object) ['bar' => 'bar']], false],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testIntersectsChecksIfTwoArraysHaveAtLeastOneElementInCommon($lists, $res)
  {
    $intersect = f\intersects(...$lists);

    $this->assertEquals($res, $intersect);
  }
}
