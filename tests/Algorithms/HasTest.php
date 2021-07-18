<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class HasTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        [
          (object) [(object) \range(1, 9), 'foo', 'bar'],
          6,
        ],
        true,
      ],
      [
        [
          ['foo', 'bar', 'baz'],
          'foo-bar',
        ],
        false,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testHasChecksIfListContainsItem($args, $res)
  {
    $check = f\has(...$args);

    $this->assertEquals($res, $check);
  }
}
