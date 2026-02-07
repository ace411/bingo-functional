<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class AssocPathTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        ['foo' => ['bar' => \range(1, 3)]],
        ['foo', 'bar', 1],
        'foo',
        ['foo' => ['bar' => [1, 'foo', 3]]],
      ],
      [
        (object) ['foo' => (object) ['bar' => ['baz' => 3]]],
        ['foo', 'bar', 'baz'],
        'baz',
        (object) [
          'foo'     => (object) [
            'bar'   => (object) [
              'baz' => 'baz',
            ],
          ],
        ],
      ],
      [
        [],
        'foo.bar[1]',
        'bar',
        ['foo' => ['bar' => [1 => 'bar']]],
      ],
      [
        (object) [
          'foo' => 12,
          'bar' => (object) \range(1, 3),
        ],
        'foo.bar.qux',
        'quux',
        (object) [
          'foo'     => (object) [
            'bar'   => (object) [
              'qux' => 'quux',
            ],
          ],
          'bar'     => (object) \range(1, 3),
        ],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testAssocClonesListAndOverwritesValueAtSpecifiedIndex($list, $path, $val, $res)
  {
    $assoc = f\assocPath($path, $val, $list);

    $this->assertEquals($res, $assoc);
  }
}
