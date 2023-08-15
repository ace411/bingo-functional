<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class FilterDeepTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        function ($val) {
          return $val % 2 == 0;
        },
        [1, 2, [3, 4, 5, 6]],
        [1 => 2, 2 => [1 => 4, 3 => 6]],
      ],
      [
        function ($val) {
          return (
            \function_exists('mb_strlen') ?
              \mb_strlen($val, 'utf-8') :
              \strlen($val)
          ) > 3;
        },
        ['foo', ['bar', 'fooz'], 'foo-bar'],
        [1 => [1 => 'fooz'], 2 => 'foo-bar'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testfilterRemovesItemsThatDoNotConformToBooleanPredicate($func, $list, $res)
  {
    $filter = f\filterDeep($func, $list);

    $this->assertEquals($res, $filter);
  }
}
