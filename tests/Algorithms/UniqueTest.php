<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class UniqueTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        [1, 3, 'foo', 9, 'foo', 'baz'],
        [1, 3, 'foo', 9, 'baz'],
      ],
      [
        ['foo', 'bar', 'baz', 'baz', 'fooz', 'baz'],
        ['foo', 'bar', 'baz', 'fooz'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testuniquePurgesDuplicatesFromArray($list, $res)
  {
    $unique = f\unique($list);

    $this->assertEquals($res, \array_values($unique));
  }
}
