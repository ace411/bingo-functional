<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class KeysExistTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
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
