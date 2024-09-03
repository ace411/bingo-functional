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
        0,
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
        0,
        (object) [2 => 'foo-bar'],
      ],
      [
        function ($val, $key) {
          return (
            (
              \extension_loaded('mbstring') ?
                '\mb_strlen' :
                '\strlen'
            )($key) > 3
          ) && f\equals($val % 2, 0);
        },
        [
          'foo'  => 12,
          'fooz' => 4,
          'bar'  => 223,
          'baz'  => 25,
        ],
        ARRAY_FILTER_USE_BOTH,
        ['fooz' => 4],
      ],
      [
        function ($val, $key) {
          return (
            (
              \extension_loaded('mbstring') ?
                '\mb_strlen' :
                '\strlen'
            )($key) > 3
          ) && f\equals($val % 2, 0);
        },
        (object) [
          'foo'  => 12,
          'fooz' => 4,
          'bar'  => 223,
          'baz'  => 25,
        ],
        ARRAY_FILTER_USE_BOTH,
        (object) ['fooz' => 4],
      ],
      [
        function (string $key) {
          return (
            \extension_loaded('mbstring') ?
              '\mb_strlen' :
              '\strlen'
          )($key) > 3;
        },
        (object) [
          'foo'  => 12,
          'fooz' => 4,
          'bar'  => 223,
          'baz'  => 25,
        ],
        ARRAY_FILTER_USE_KEY,
        (object) ['fooz' => 4],
      ],
      [
        function (string $key) {
          return (
            \extension_loaded('mbstring') ?
              '\mb_strlen' :
              '\strlen'
          )($key) > 3;
        },
        [
          'foo'  => 12,
          'fooz' => 4,
          'bar'  => 223,
          'baz'  => 25,
        ],
        ARRAY_FILTER_USE_KEY,
        ['fooz' => 4],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testfilterRemovesItemsThatDoNotConformToBooleanPredicate($func, $list, $mode, $res)
  {
    $filter = f\filter($func, $list, $mode);

    $this->assertEquals($res, $filter);
  }
}
