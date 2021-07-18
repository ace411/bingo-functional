<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class DropRightTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [\range(1, 7), 3, [1, 2, 3, 4]],
      [['foo' => 'foo', 'bar' => 'bar'], 1, ['foo' => 'foo']],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testDropLeftErasesElementsFromBeginningOfList($list, $count, $res)
  {
    $dropped = f\dropRight($list, $count);

    $this->assertEquals($res, $dropped);
    // $this->assertIsArray($dropped);
    $this->assertTrue(\is_array($dropped));
  }
}
