<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Monads;

use Chemem\Bingo\Functional\Algorithms as f;
use Chemem\Bingo\Functional\Functors\Monads as m;
use Chemem\Bingo\Functional\Functors\Maybe\Maybe;

class DoTest extends \PHPUnit\Framework\TestCase
{
  public function doProvider()
  {
    return [
      [
        [
          m\let('x', m\ListMonad\fromValue('foo')),
          m\let('y', m\ListMonad\fromValue('bar')),
          m\in(['x', 'y'], function ($x, $y) {
            return f\concat('-', $x, $y);
          }),
        ],
        'extract',
        ['foo-bar'],
      ],
      [
        [
          m\let('a', Maybe::fromValue(2)),
          m\let('b', m\in(['a'], function ($a) {
            return $a ** 2;
          })),
          m\in(['a', 'b'], function ($a, $b) {
            return $a + $b;
          }),
        ],
        'getJust',
        6,
      ],
    ];
  }

  /**
   * @dataProvider doProvider
   */
  public function testdoCreatesMonadActionProcessingPipeline($args, $extract, $res)
  {
    $do = m\doN(...$args);

    $this->assertTrue($do instanceof m\Monad);
    $this->assertEquals($res, $do->$extract());
  }
}
