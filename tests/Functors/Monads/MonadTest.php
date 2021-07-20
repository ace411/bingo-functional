<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Monads;

use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Functors\Monads as m;
use Chemem\Bingo\Functional\Functors\Monads\Maybe;
use Chemem\Bingo\Functional\Functors\Monads\Right;
use Chemem\Bingo\Functional\Functors\Monads\Just;

class MonadTest extends \PHPUnit\Framework\TestCase
{
  public function bindProvider()
  {
    return [
      [
        function ($val, $monad) {
          return $monad::of($val * 2);
        },
        2,
        4,
      ],
      [
        function ($val, $monad) {
          return $monad::of($val . '-foo');
        },
        'bar',
        'bar-foo',
      ],
    ];
  }

  /**
   * @dataProvider bindProvider
   */
  public function testbindSequentiallyComposesTwoMonadActions($func, $arg, $res)
  {
    $impure = m\bind(
      f\partialRight($func, m\IO::class),
      m\IO\IO($arg)
    );

    $this->assertTrue($impure instanceof m\Monad);
    $this->assertEquals($res, $impure->exec());
  }

  public function mcomposeProvider()
  {
    return [
      [
        [
          function ($val, $monad) {
            return $monad::of($val + 2);
          },
          function ($val, $monad) {
            return $monad::of($val / 4);
          },
          function ($val, $monad) {
            return $monad::of($val ** 2);
          },
        ],
        8,
        4,
      ],
    ];
  }

  /**
   * @dataProvider mcomposeProvider
   */
  public function testmcomposeComposesMonadFunctionsFromRightToLeft($funcs, $arg, $res)
  {
    $ops = m\mcompose(
      ...f\map(function ($closure) {
        return f\partialRight($closure, Just::class);
      }, $funcs)
    );

    $this->assertInstanceOf(\Closure::class, $ops);
    $this->assertEquals($res, $ops(Maybe::just($arg))->getJust());
  }

  public function foldMProvider()
  {
    return [
      [
        function ($acc, $val, $monad) {
          return $monad::of($val > $acc ? $val : $acc);
        },
        [5, 12, 3, 1],
        0,
        12,
      ],
      [
        function ($acc, $val, $monad) {
          return $monad::of(f\concat(',', $val, $acc));
        },
        ['foo', 'bar', 'baz'],
        '',
        ',foo,bar,baz',
      ],
    ];
  }

  /**
   * @dataProvider foldMProvider
   */
  public function testfoldMTransformsListIntoSingleMonadValue($func, $list, $acc, $res)
  {
    $reader = m\foldM(f\partialRight($func, m\Reader::class), $list, $acc);

    $this->assertTrue($reader instanceof m\Monad);
    $this->assertEquals($res, $reader->run(null));
  }

  public function mapMProvider()
  {
    return [
      [
        function ($val, $monad) {
          return $monad::of($val ** 2);
        },
        \range(1, 3),
        [1, 4, 9],
      ],
      [
        function ($val, $monad) {
          return $monad::of(f\concat('-', 'foo', $val));
        },
        ['foo', 'bar'],
        ['foo-foo', 'foo-bar'],
      ],
    ];
  }

  /**
   * @dataProvider mapMProvider
   */
  public function testmapMTransformsEveryListItemInMonadContext($func, $list, $res)
  {
    $map = m\mapM(f\partialRight($func, Right::class), $list);

    $this->assertTrue($map instanceof m\Monad);
    $this->assertEquals($res, $map->getRight());
  }

  public function filterMProvider()
  {
    return [
      [
        function ($val, $monad) {
          return $monad::of($val % 2 == 0);
        },
        \range(1, 5),
        [2, 4],
      ],
      [
        function ($val, $monad) {
          return $monad::of(\mb_strlen($val, 'utf-8') > 3);
        },
        ['foo', 'bar', 'foo-bar'],
        ['foo-bar'],
      ],
    ];
  }

  /**
   * @dataProvider filterMProvider
   */
  public function testfilterMBehavesLikefilterInMonadContext($func, $list, $res)
  {
    $filter = m\filterM(f\partialRight($func, m\State::class), $list);

    $this->assertTrue($filter instanceof m\Monad);
    $this->assertEquals($res, f\head($filter->run(null)));
  }

  public function liftMProvider()
  {
    return [
      [
        [
          f\K(function ($val) {
            return $val ** 2;
          }),
          m\Reader::of(2),
        ],
        4,
      ],
      [
        ['strtoupper', m\Writer::of('foo')],
        ['FOO', []],
      ],
    ];
  }

  /**
   * @dataProvider liftMProvider
   */
  public function testliftMPromotesFunctionToMonad($args, $res)
  {
    $lift = m\liftM(...$args);

    $this->assertTrue($lift instanceof m\Monad);
    $this->assertEquals($res, $lift->run(null));
  }
}
