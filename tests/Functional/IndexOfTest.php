<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class IndexOfTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        ['foo' => 'foo', 'bar' => 12],
        12,
        null,
        'bar',
      ],
      [(object) \range(1, 4), 2, null, 1],
      [(object) ['foo', 'bar' => 'bar'], 'baz', 'undef', 'undef'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testIndexOfReturnsIndexAssociatedWithSpecifiedValue($list, $val, $def, $res)
  {
    $index = f\indexOf($list, $val, $def);

    $this->assertEquals($res, $index);
  }
}
