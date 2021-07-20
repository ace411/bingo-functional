<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class ExtendTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        [\range(1, 3), \range(4, 6)],
        \range(1, 6),
      ],
      [
        [['foo' => 'foo', 'bar' => 'bar'], ['baz' => 'baz']],
        [
          'foo' => 'foo',
          'bar' => 'bar',
          'baz' => 'baz',
        ],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testextendConcatenatesMultipleLists($lists, $res)
  {
    $final = f\extend(...$lists);

    $this->assertEquals($res, $final);
  }
}
