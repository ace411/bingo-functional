<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class RenameKeysTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        ['foo' => 'foo', 'bar' => 'bar'],
        [['foo', 'x'], ['bar', 'y']],
        ['x' => 'foo', 'y' => 'bar'],
      ],
      [
        (object) \range(1, 3),
        [[0, 'foo'], [2, 'bar']],
        (object) ['foo' => 1, 1 => 2, 'bar' => 3],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testrenameKeysAllowsForArbitraryRenamingOfListKeys($list, $pairs, $res)
  {
    $renamed = f\renameKeys($list, ...$pairs);

    $this->assertEquals($res, $renamed);
  }
}
