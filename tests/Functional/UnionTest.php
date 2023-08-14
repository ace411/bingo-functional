<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class UnionTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        [\range(1, 3), \range(2, 6)],
        \range(1, 6),
      ],
      [
        [['foo', ['bar']], ['baz', 'foo']],
        ['foo', 'bar', 'baz'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testunionCombinesMultipleLists($args, $res)
  {
    $union = f\union(...$args);

    $this->assertEquals($res, \array_values($union));
  }
}
