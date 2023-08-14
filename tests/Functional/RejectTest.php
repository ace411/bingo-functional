<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class RejectTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
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
          return (
            \function_exists('mb_strlen') ?
              \mb_strlen($val, 'utf-8') :
              \strlen($val)
          ) > 3;
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
