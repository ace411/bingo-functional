<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use PHPUnit\Framework\TestCase;

use function Chemem\Bingo\Functional\keys;

class KeysTest extends TestCase
{
  public static function contextProvider(): array
  {
    return [
      [
        [
          3 => 'foo',
          6 => 'bar',
          1 => 'baz',
        ],
        [3, 6, 1],
      ],
      [
        (object) [
          'foo' => '_foo',
          'baz' => '_baz'
        ],
        ['foo', 'baz'],
      ],
      [
        [
          'foo' => '_foo',
          'baz' => '_baz',
        ],
        ['foo', 'baz'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testKeysReturnsAnArrayWhoseConstituentsAreTheKeysInASpecifiedList($list, $result)
  {
    $keys = keys($list);

    $this->assertIsArray($keys);
    $this->assertEquals($result, $keys);
  }
}
