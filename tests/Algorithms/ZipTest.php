<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class ZipTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [[\range(1, 2), ['pg', 'sg']], [[1, 'pg'], [2, 'sg']]],
      [[['foo'], ['bar'], ['baz']], [['foo', 'bar', 'baz']]],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testzipCreatesZippedArray($lists, $res)
  {
    $zipped = f\zip(...$lists);

    $this->assertEquals($res, $zipped);
  }
}
