<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class JsonDecodeTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider(): iterable
  {
    return [
      [
        [
          \json_encode(
            [
              'foo' => \json_encode(['foo' => 'bar']),
              'baz' => \json_encode(\range(1, 5)),
              'bar' => 2,
            ]
          ),
          true,
        ],
        [
          'foo' => ['foo' => 'bar'],
          'baz' => \range(1, 5),
          'bar' => 2,
        ],
      ],
      [
        [
          \json_encode(
            [
              'foo' => \json_encode(['foo' => 'bar']),
              'baz' => \json_encode(\range(1, 5)),
              'bar' => 2,
            ]
          ),
          false,
          5000,
        ],
        (object) [
          'foo' => (object) ['foo' => 'bar'],
          'baz' => \range(1, 5),
          'bar' => 2,
        ],
      ],
      [
        [
          \json_encode(
            [
              'foo' => 1,
              'bar' => 2,
              'baz' => 3,
            ]
          ),
          true,
        ],
        [
          'foo' => 1,
          'bar' => 2,
          'baz' => 3,
        ],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testjsonDecodeRecursivelyDecodesJSON($args, $result)
  {
    $data = f\jsonDecode(...$args);

    $this->assertEquals($result, $data);
  }
}
