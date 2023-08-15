<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class AddKeysTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        [
          'foo' => 'foo',
          'bar' => 'bar',
          'baz' => 'baz',
        ],
        ['bar', 'baz'],
        ['bar' => 'bar', 'baz' => 'baz'],
      ],
      [
        (object) ['foo' => 'foo', 'bar' => 'bar'],
        ['baz'],
        (object) [],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testAddKeysReturnsListContainingValuesAssociatedWithSpecifiedKeys($list, $keys, $res)
  {
    $assoc = f\addKeys($list, ...$keys);

    $this->assertEquals($res, $assoc);
  }
}
