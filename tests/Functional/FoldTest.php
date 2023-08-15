<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class FoldTest extends \PHPunit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        function ($acc, $val) {
          return $acc + $val;
        },
        \range(1, 5),
        0,
        15,
      ],
      [
        function ($acc, $val) {
          return f\concat(',', $val, $acc);
        },
        ['foo', 'bar', 'baz'],
        '',
        'baz,bar,foo,',
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testFoldTransformsListIntoSingleValue($func, $list, $acc, $res)
  {
    $reduce = f\fold($func, $list, $acc);

    $this->assertEquals($res, $reduce);
  }
}
