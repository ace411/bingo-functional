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
        (object) ['foo' => (object) ['bar' => ['baz' => 'baz']]],
      ],
      [
        [],
        'foo.bar[1]',
        'bar',
        ['foo' => ['bar' => [1 => 'bar']]],
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
