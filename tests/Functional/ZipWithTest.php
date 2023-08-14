<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class ZipWithTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        function ($int, $str) {
          return $int + (
            \extension_loaded('mbstring') ?
              \mb_strlen($str, 'utf-8') :
              \strlen($str)
          );
        },
        [\range(1, 3), ['foo', 'bar', 'baz']],
        \range(4, 6),
      ],
      [
        f\partial(f\concat, ', '),
        [['foo', 'bar'], ['fooz', 'baz']],
        ['foo, fooz', 'bar, baz'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testzipWithZipsListInAccordanceWithFunctionRubric($func, $lists, $res)
  {
    $zipped = f\zipWith($func, ...$lists);

    $this->assertEquals($res, $zipped);
  }
}
