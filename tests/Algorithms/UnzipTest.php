<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class UnzipTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        [[1, 'pg'], [2, 'sg']],
        [[1, 2], ['pg', 'sg']],
      ],
      [
        [['foo', 'bar', 'baz']],
        [['foo'], ['bar'], ['baz']],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testunzipUnzipsZippedArrays($list, $res)
  {
    $unzipped = f\unzip($list);

    $this->assertEquals($res, $unzipped);
  }
}
