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
        [
          'foo'     => [
            'bar'   => [
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
        [
          'foo'     => [
            'bar'   => [
              'qux' => 'quux',
            ],
          ],
          'bar'     => (object) \range(1, 3),
        ],
      ],
      [
        new class () {
          public $foo = 12;
          public $bar = [1, 2, 3];
        },
        'qux.quux',
        ['foo' => 'foo'],
        [
          'foo'     => 12,
          'bar'     => [1, 2, 3],
          'qux'     => [
            'quux'  => [
              'foo' => 'foo',
            ],
          ],
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
