<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class DropLeftTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        \range(1, 7),
        3,
        [
          3 => 4,
          4 => 5,
          5 => 6,
          6 => 7
        ],
      ],
      [
        ['foo' => 'foo', 'bar' => 'bar'],
        1,
        ['bar' => 'bar'],
      ],
      [
        (object) ['foo' => 'foo', 'bar' => 'bar'],
        1,
        (object) ['bar' => 'bar'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testDropLeftErasesElementsFromBeginningOfList($list, $count, $res)
  {
    $dropped = f\dropLeft($list, $count);

    $this->assertEquals($res, $dropped);
    $this->assertTrue(
      \is_array($dropped) || \is_object($dropped)
    );
  }
}
