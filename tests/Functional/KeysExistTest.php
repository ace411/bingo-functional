<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class KeysExistTest extends \PHPUnit\Framework\TestCase
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
        ['foo', 'bar'],
        true,
      ],
      [
        (object) ['foo' => 'foo', 'bar' => 'bar'],
        ['baz', 'bar'],
        false,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testkeysExistChecksIfSpecifiedKeysExistInList($list, $keys, $res)
  {
    $keysExist = f\keysExist($list, ...$keys);

    $this->assertEquals($res, $keysExist);
  }
}
