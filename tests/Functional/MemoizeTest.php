<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class MemoizeTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        [
          function (int $x): int {
            return $x * 2;
          },
          true,
        ],
        [10],
        20,
      ],
      [
        [
          function (int $x): int {
            return $x * 2;
          },
          true,
        ],
        [10],
        20,
      ],
      [
        [
          function (int $x, int $y = 3): int {
            return $x + $y;
          },
        ],
        [20, 3],
        23,
      ],
      [
        [
          function (int $x, int $y = 3): int {
            return $x + $y;
          },
        ],
        [20, 3],
        23,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testmemoizeCachesFunction($memoargs, $fargs, $res)
  {
    $memoized = f\memoize(...$memoargs);

    $this->assertEquals($res, $memoized(...$fargs));

    if (!\extension_loaded('apcu')) {
      $this->assertNotEmpty(
        f\filter(
          function (string $key): bool {
            return (bool) \preg_match(
              '/^(Chemem\\\\Bingo\\\\Functional\\\\memoize)/',
              $key
            );
          },
          $GLOBALS,
          \ARRAY_FILTER_USE_KEY
        )
      );
    } else {
      $acc = [];

      foreach (new \APCUIterator() as $key => $value) {
        if (
          (bool) \preg_match(
            '/^(Chemem\\\\Bingo\\\\Functional\\\\memoize)/',
            $key
          )
        ) {
          $acc[$key] = $value;
        }
      }

      $this->assertNotEmpty($acc);
    }
  }
}
