<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class FirstIndexOfTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        [
          'foo' => [
            'bar' => ['foo', 'fooz'],
            'baz' => 'bar',
          ],
        ],
        'bar',
        'undefined',
        'baz',
      ],
      [(object) ['foo', 'bar'], 'baz', 'undefined', 'undefined'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testfirstIndexOfComputesFirstIndexOfValue($list, $key, $def, $res)
  {
    $first = f\firstIndexOf($list, $key, $def);

    $this->assertEquals($res, $first);
  }
}
