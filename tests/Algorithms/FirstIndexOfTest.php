<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class FirstIndexOfTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
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
