<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use PHPUnit\Framework\TestCase;

use function Chemem\Bingo\Functional\values;

class ValuesTest extends TestCase
{
  public static function contextProvider(): array
  {
    return [
      [
        \range(1, 5),
        \range(1, 5),
      ],
      [
        (object) [
          'foo' => '_foo',
          'baz' => '_baz'
        ],
        ['_foo', '_baz'],
      ],
      [
        [
          'foo' => '_foo',
          'baz' => '_baz',
        ],
        ['_foo', '_baz'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testvaluesReturnsAnArrayWhoseConstituentsAreTheValuesInASpecifiedList($list, $result)
  {
    $values = values($list);

    $this->assertIsArray($values);
    $this->assertEquals($result, $values);
  }
}
