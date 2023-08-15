<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class DropRightTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [\range(1, 7), 3, [1, 2, 3, 4]],
      [
        [
          'foo' => 'foo',
          'bar' => 'bar',
        ],
        1,
        ['foo' => 'foo'],
      ],
      [
        (object) [
          'foo' => 'foo',
          'bar' => 'bar',
          'baz' => 'baz',
        ],
        2,
        (object) ['foo' => 'foo'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testDropRightErasesElementsFromEndOfList($list, $count, $res)
  {
    $dropped = f\dropRight($list, $count);

    $this->assertEquals($res, $dropped);
    $this->assertTrue(
      \is_array($dropped) || \is_object($dropped)
    );
  }
}
