<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class PluckPathTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [['x', 'y', 1], ['x' => ['y' => \range(1, 3)]], null,  2],
      [[1, 'foo'], (object) [3, ['foo' => 'baz']], 'undefined', 'baz'],
      [['foo', 'bar'], \range(1, 3), 0, 0],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testpluckPathReturnsValueAssociatedWithKeyAtTheEndOfTraversablePath($path, $list, $def, $res)
  {
    $pluck = f\pluckPath($path, $list, $def);

    $this->assertEquals($res, $pluck);
  }
}
