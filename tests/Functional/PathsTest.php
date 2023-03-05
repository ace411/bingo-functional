<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class PathsTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        [
          [
            'foo' => [
              'bar' => ['baz' => 12]
            ],
            'bar' => [
              ['foo' => 'foo'],
            ],
          ],
        ],
        [
          'foo.bar.baz' => 12,
          'bar.0.foo'   => 'foo',
        ],
      ],
      [
        [
          [
            'foo' => [
              'bar' => ['baz' => 12]
            ],
            'bar' => [
              ['foo' => 'foo'],
            ],
          ],
          '->',
        ],
        [
          'foo->bar->baz' => 12,
          'bar->0->foo'   => 'foo',
        ],
      ],
      [
        [
          [
            'foo' => [
              'bar' => ['baz' => 12]
            ],
            'bar' => [
              ['foo' => 'foo'],
            ],
          ],
          '.',
          function ($prefix, $key, $glue) {
            return \sprintf(
              '%s%s%s',
              $prefix,
              \is_int($key) ? \sprintf('[%d]', $key) : $key,
              $glue,
            );
          },
          '.',
        ],
        [
          '.foo.bar.baz'  => 12,
          '.bar.[0].foo'  => 'foo',
        ],
      ],
      [[[]], []],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testpathsComputesPathsToValuesInListStructures($args, $result)
  {
    $paths = f\paths(...$args);

    $this->assertIsArray($paths);
    $this->assertEquals($result, $paths);
  }
}
