<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class AssocTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        ['foo' => 'foo', 'bar' => 'bar'],
        'bar',
        32,
        ['foo' => 'foo', 'bar' => 32],
      ],
      [
        (object) ['foo' => 'foo', 'bar' => 'bar'],
        'baz',
        12.2,
        (object) [
          'foo' => 'foo',
          'bar' => 'bar',
          'baz' => 12.2,
        ],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testAssocClonesListAndOverwritesValueAtSpecifiedIndex($list, $key, $val, $res)
  {
    $assoc = f\assoc($key, $val, $list);

    $this->assertEquals($res, $assoc);
  }
}
