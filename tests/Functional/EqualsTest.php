<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Functors\Monads as m;

class EqualsTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      // array comparisons
      [
        [
          ['bingo-functional'],
          ['functional'],
        ],
        false
      ],
      [
        [
          ['foo' => 'foo'],
          ['bar' => 'bar'],
        ],
        false,
      ],
      [
        [
          ['functional'],
          ['functional'],
        ],
        true,
      ],
      [
        [
          ['foo' => 'foo', 'bar' => 'bar'],
          ['foo' => 'foo', 'bar' => 'bar'],
        ],
        true,
      ],
      // string comparisons
      [['chemem', 'mike'], false],
      [['mike', 'mike'], true],
      // integer comparisons
      [[12, 4], false],
      [[3, 3], true],
      // float/double comparisons
      [[12.244, 12.24], false],
      [[2.22, 2.22], true],
      // null comparisons
      [[null, null], true],
      // cross comparisons
      [
        [null, \range(1, 3)],
        false,
      ],
      [
        ['foo', 11.32],
        false,
      ],
      // object comparisons
      [
        [(object)\range(1, 3), (object)\range(2, 3)],
        false,
      ],
      [
        [
          m\Maybe::fromValue(12),
          m\Maybe::fromValue(
            function ($x) {
              return $x + 1;
            }
          ),
        ],
        false,
      ],
      [
        [
          m\Maybe::fromValue((object)\range(1, 3)),
          m\Maybe::fromValue((object)\range(1, 3)),
        ],
        false,
      ],
      [
        [
          function ($x, $y) {
            return $x + $y;
          },
          function ($x, $y) {
            return $x - $y;
          },
        ],
        false,
      ],
      [
        [
          \fopen(f\filePath(0, 'io.test.txt'), 'r'),
          \curl_init(),
        ],
        false
      ],
      [
        [
          function ($x, $y) {
            static $val = 2;
            return $val + $x + $y;
          },
          function ($x, $y) {
            return $x + $y + 2;
          },
        ],
        false,
      ],
      [
        [f\map, f\filter],
        false,
      ],
      [
        [f\map, f\map],
        true,
      ],
      [
        [(object)\range(1, 3), (object)\range(1, 3)],
        true,
      ],
      [
        [\curl_init(), \curl_init()],
        true,
      ],
      [
        // recursively traverse object props
        [
          m\Maybe::fromValue((object)\range(1, 3)),
          m\Maybe::fromValue((object)\range(1, 3)),
          true,
        ],
        true,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testequalsPerformsArtifactComparisonsToAscertainEquivalence($args, $result)
  {
    $comp = f\equals(...$args);

    $this->assertIsBool($comp);
    $this->assertEquals($result, $comp);
  }
}
