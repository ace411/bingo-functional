<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class FilterTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
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
          return \mb_strlen($val, 'utf-8') > 3;
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
