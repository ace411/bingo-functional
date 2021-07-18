<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class RejectTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        function ($val) {
          return $val % 2 == 0;
        },
        \range(1, 5),
        [0 => 1, 2 => 3, 4 => 5],
      ],
      [
        function ($val) {
          return \mb_strlen($val, 'utf-8') > 3;
        },
        (object) ['foo', 'bar', 'foo-bar'],
        (object) [0 => 'foo', 1 => 'bar'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testRejectRemovesItemsThatConformToBooleanPredicate($func, $list, $res)
  {
    $filter = f\reject($func, $list);

    $this->assertEquals($res, $filter);
  }
}
