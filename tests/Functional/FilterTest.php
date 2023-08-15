<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class FilterTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        function ($val) {
          return $val % 2 == 0;
        },
        \range(1, 5),
        [1 => 2, 3 => 4],
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
        (object) [2 => 'foo-bar'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testfilterRemovesItemsThatDoNotConformToBooleanPredicate($func, $list, $res)
  {
    $filter = f\filter($func, $list);

    $this->assertEquals($res, $filter);
  }
}
