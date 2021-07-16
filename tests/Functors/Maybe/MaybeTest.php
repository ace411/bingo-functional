<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Maybe;

\error_reporting(0);

use Eris\Generator;
use Chemem\Bingo\Functional\Tests as t;
use Chemem\Bingo\Functional\Functors\Maybe;
use Chemem\Bingo\Functional\Algorithms as f;

class MaybeTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function MaybeObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\int(),
        Generator\bool()
      )
      ->then(function ($val, bool $just) {
        $maybe = Maybe\Maybe::fromValue($val, $just ? null : $val);

        $fnx = function ($res) {
          return $res ** 2;
        };
        $fny = function ($res) {
          return $res + 10;
        };

        $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], t\functorLaws($maybe, $fnx, $fny));
      });
  }

  /**
   * @test
   */
  public function MaybeObeysMonadLaws()
  {
    $this
      ->forAll(
        Generator\names(),
        Generator\bool()
      )
      ->then(function ($res, bool $just) {
        $maybe  = Maybe\Maybe::fromValue($res, $just ? null : $res);
        $fnx    = function ($str) use ($just) {
          $expr = f\concat(': ', 'name', $str); // memoize expression

          return Maybe\Maybe::fromValue($expr, $just ? null : $expr);
        };

        $fny    = function ($str) use ($just) {
          $expr = f\toWords($str, '/([\s:])+/');

          return Maybe\Maybe::fromValue($expr, $just ? null : $expr);
        };

        $this->assertEquals(
          [
            'left-identity'   => true,
            'right-identity'  => true,
            'associativity'   => true,
          ],
          t\monadLaws(
            $maybe,
            $fnx,
            $fny,
            // test both Just and Nothing sub-types individually
            $just ? Maybe\Just::of : Maybe\Nothing::of,
            $just ? $res : ''
          )
        );
      });
  }

  public function maybeProvider()
  {
    return [
      [
        function ($val) {
          return $val + 10;
        },
        [9, null],
        0,
        [19, 0],
      ],
    ];
  }

  /**
   * @dataProvider maybeProvider
   */
  public function testmaybePerformsCaseAnalysisOnMaybeMonad($func, $args, $def, $res)
  {
    [$argj, $argn] = $args;
    [$resj, $resn] = $res;
    $maybe         = f\partial(Maybe\maybe, $def, $func);

    $just    = $maybe(Maybe\Maybe::fromValue($argj));
    $nothing = $maybe(Maybe\Maybe::fromValue($argn));

    $this->assertEquals($resj, $just);
    $this->assertEquals($resn, $nothing);
  }

  public function fromJustProvider()
  {
    return [
      [12],
      ['foo'],
      [\range(1, 4)],
      [new \stdClass('bar')],
      [null],
    ];
  }

  /**
   * @dataProvider fromJustProvider
   */
  public function testfromJustExtractsAnElementOutOfJustMonadAndThrowsExceptionOtherwise($val)
  {
    $maybe = f\toException(function ($val) {
      return Maybe\fromJust(Maybe\Maybe::fromValue($val));
    });

    $this->assertTrue(
      $maybe($val) == $val || $maybe($val) == 'Maybe.fromJust: Nothing'
    );
  }

  public function fromMaybeProvider()
  {
    return [
      [null, 12],
      ['foo', 'foo'],
      [\range(1, 3), []],
    ];
  }

  /**
   * @dataProvider fromMaybeProvider
   */
  public function testfromMaybeExtractsJustValueFromMonadAndDefaultValueOtherwise($val, $def)
  {
    $maybe = Maybe\fromMaybe($def, Maybe\Maybe::fromValue($val));

    $this->assertTrue($maybe == $val || $maybe == $def);
  }

  public function listToMaybeProvider()
  {
    return [
      [\range(1, 5), true],
      [[], false],
    ];
  }

  /**
   * @dataProvider listToMaybeProvider
   */
  public function testlistToMaybeReturnsNothingOrJustContainingSingletonList($list, $res)
  {
    $maybe = Maybe\listToMaybe($list);

    $this->assertInstanceOf(Maybe\Maybe::class, $maybe);
    $this->assertEquals($res, Maybe\isJust($maybe));
  }

  public function maybeToListProvider()
  {
    return [[12, [12]], ['foo', ['foo']], [null, []]];
  }

  /**
   * @dataProvider maybeToListProvider
   */
  public function testmaybeToListReturnsEmptyListOrSingletonList($val, $res)
  {
    $list = Maybe\maybeToList(Maybe\Maybe::fromValue($val));

    // $this->assertIsArray($list);
    $this->assertTrue(\is_array($list));
    $this->assertEquals($res, $list);
  }

  public function catMaybesProvider()
  {
    return [
      [
        [Maybe\Maybe::fromValue(2), Maybe\Just::of('foo'), Maybe\Nothing::of(2)],
        [2, 'foo'],
      ],
      [
        [Maybe\Just::of('foo'), Maybe\Nothing::of(null), Maybe\Just::of(\range(1, 3))],
        ['foo', \range(1, 3)],
      ],
    ];
  }

  /**
   * @dataProvider catMaybesProvider
   */
  public function catMaybesReturnsListOfJustValuesInListOfMaybes($maybes, $res)
  {
    $list = Maybe\catMaybes($maybes);

    $this->assertEquals($res, $list);
  }

  public function mapMaybeProvider()
  {
    return [
      [
        function ($val) {
          return Maybe\Maybe::fromValue($val ** 2);
        },
        \range(1, 3),
        [1, 4, 9],
      ],
      [
        function ($val) {
          return Maybe\Maybe::fromValue(\strtoupper($val));
        },
        ['foo', null, 'bar'],
        ['FOO', "", 'BAR'],
      ],
    ];
  }

  /**
   * @dataProvider mapMaybeProvider
   */
  public function testmapMaybeIsAVersionofmapWhichThrowsOutElements($func, $list, $res)
  {
    $ret = Maybe\mapMaybe($func, $list);

    $this->assertEquals($res, $ret);
  }

  public function liftProvider()
  {
    return [
      [
        function ($fst, $snd) {
          return $fst / $snd;
        },
        [null, 3],
      ],
      [
        function ($fst) {
          return $fst ** 2;
        },
        [null],
      ],
    ];
  }

  /**
   * @dataProvider liftProvider
   */
  public function testMaybeMonadIsLiftable($func, $args)
  {
    $lifted = Maybe\Maybe::lift($func);
    $params = f\map(function ($arg) {
      return Maybe\Maybe::fromValue($arg);
    }, $args);

    $this->assertInstanceOf(\Closure::class, $lifted);
    $this->assertInstanceOf(Maybe\Maybe::class, $lifted(...$params));
  }
}
