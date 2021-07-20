<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class UnionWithTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        function ($fst, $snd) {
          return f\isArrayOf($fst) == 'integer' &&
            f\isArrayOf($snd) == 'string';
        },
        [\range(1, 3), \range(2, 6)],
        [],
      ],
      [
        function ($fst, $snd) {
          return f\pick($fst, 'foo') == f\pick($snd, 'foo');
        },
        [['foo', ['bar']], ['baz', 'foo']],
        ['foo', 'bar', 'baz'],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testunionWithCombinesMultipleListsConditionally($func, $args, $res)
  {
    $union = f\unionWith($func, ...$args);

    $this->assertEquals($res, $union);
  }
}
