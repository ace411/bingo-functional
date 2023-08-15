<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class LastIndexOfTest extends \PHPUnit\Framework\TestCase
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
          'fooz' => 'bar',
        ],
        'bar',
        'undefined',
        'fooz',
      ],
      [(object) ['foo', 'bar'], 'baz', 'undefined', 'undefined'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testlastIndexOfComputesLastIndexOfValue($list, $key, $def, $res)
  {
    $last = f\lastIndexOf($list, $key, $def);

    $this->assertEquals($res, $last);
  }
}
