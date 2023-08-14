<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class OmitTest extends \PHPUnit\Framework\TestCase
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
        ['foo' => 'foo'],
      ],
      [
        (object) ['foo' => 'foo', 'bar' => 'bar'],
        ['baz'],
        (object) ['foo' => 'foo', 'bar' => 'bar'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testomitPurgesListOfValuesThatCorrespondToSpecifiedKeys($list, $keys, $res)
  {
    $omit = f\omit($list, ...$keys);

    $this->assertEquals($res, $omit);
  }
}
