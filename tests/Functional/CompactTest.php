<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class CompactTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        [1, 'foo', 'bar', false, null],
        [1, 'foo', 'bar'],
      ],
      [
        (object) [1.2, false, 'foo'],
        (object) [1.2, 2 => 'foo'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testCompactPurgesListOfFalsyValues($list, $res)
  {
    $compact = f\compact($list);

    $this->assertEquals($res, $compact);
  }
}
