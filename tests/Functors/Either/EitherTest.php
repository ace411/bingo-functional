<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Either;

\error_reporting(0);

use Eris\Generator;
use Chemem\Bingo\Functional\Tests as t;
use Chemem\Bingo\Functional\Functors\Either;
use Chemem\Bingo\Functional\Algorithms as f;

class EitherTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function EitherObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\int(),
        Generator\constant(0),
        Generator\bool()
      )
      ->then(function ($val, $const, $right) {
        $either = $right ?
          Either\Either::right($val) :
          Either\Either::left($const);

        $fnx = function ($res) {
          return $res ** 2;
        };
        $fny = function ($res) {
          return $res + 10;
        };

        $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], t\functorLaws($either, $fnx, $fny));
      });
  }

  /**
   * @test
   */
  public function EitherObeysMonadLaws()
  {
    $this
      ->forAll(
        Generator\names(),
        Generator\constant('left'),
        Generator\bool()
      )
      ->then(function ($res, $const, bool $right) {
        $either  = $right ?
          Either\Either::right($res) :
          Either\Either::left($const);
        $fnx    = function ($str) use ($right, $const) {
          $expr = f\concat(': ', 'name', $str);

          return $right ?
            Either\Either::right($expr) :
            Either\Either::left($const);
        };

        $fny    = function ($str) use ($right, $const) {
          $expr = f\toWords($str, '/([\s:])+/');

          return $right ?
            Either\Either::right($expr) :
            Either\Either::left($const);
        };

        $this->assertEquals(
          [
            'left-identity'   => true,
            'right-identity'  => true,
            'associativity'   => true,
          ],
          t\monadLaws(
            $either,
            $fnx,
            $fny,
            // test both Right and Left sub-types individually
            $right ? Either\Right::of : Either\Left::of,
            $right ? $res : $const
          )
        );
      });
  }

  public function eitherProvider()
  {
    return [
      [
        'strtoupper',
        function ($val) {
          return 12 / $val;
        },
        [2, 'division error'],
        [6, 'DIVISION ERROR'],
      ],
    ];
  }

  /**
   * @dataProvider eitherProvider
   */
  public function testeitherPerformsCaseAnalysisOnEitherType($left, $right, $args, $res)
  {
    [$argr, $argl] = $args;
    [$rres, $lres] = $res;

    $rval = Either\either($left, $right, Either\Right::of($argr));
    $lval = Either\either($left, $right, Either\Left::of($argl));

    $this->assertEquals($lres, $lval);
    $this->assertEquals($rres, $rval);
  }

  public function leftsProvider()
  {
    return [
      [
        [Either\Right::of(3), Either\Left::of(0), Either\Left::of('foo')],
        [0, 'foo'],
      ],
      [
        [Either\Right::of('foo'), Either\Left::of('bar')],
        ['bar'],
      ],
    ];
  }

  /**
   * @dataProvider leftsProvider
   */
  public function testleftsExtractsLeftInstancesFromListOfEithers($list, $res)
  {
    $lefts = Either\lefts($list);

    $this->assertEquals($res, $lefts);
  }

  public function fromLeftProvider()
  {
    return [
      [Either\Left::of(2), null, 2],
      [Either\Right::of('foo'), 'undefined', 'undefined'],
    ];
  }

  /**
   * @dataProvider fromLeftProvider
   */
  public function testfromLeftReturnsLeftValueIfPresentAndDefaultValueOtherwise($val, $def, $res)
  {
    $left = Either\fromLeft($def, $val);

    $this->assertEquals($res, $left);
  }

  public function fromRightProvider()
  {
    return [
      [Either\Left::of(2), 0, 0],
      [Either\Right::of('foo'), null, 'foo'],
    ];
  }

  /**
   * @dataProvider fromRightProvider
   */
  public function testfromRightReturnsRightValueIfPresentAndDefaultValueOtherwise($val, $def, $res)
  {
    $right = Either\fromRight($def, $val);

    $this->assertEquals($res, $right);
  }

  public function partitionEithersProvider()
  {
    return [
      [
        [Either\Left::of(2), Either\Right::of('foo'), Either\Left::of(9)],
        ['left' => [2, 9], 'right' => ['foo']],
      ],
      [
        [Either\Right::of(2), Either\Right::of('foo'), Either\Left::of(9)],
        ['left' => [9], 'right' => [2, 'foo']],
      ],
    ];
  }

  /**
   * @dataProvider partitionEithersProvider
   */
  public function testpartitionEithersParitionsListOfEithers($list, $res)
  {
    $partitioned = Either\partitionEithers($list);

    $this->assertEquals($res, $partitioned);
    $this->assertTrue(f\keysExist($partitioned, 'left', 'right'));
  }

  public function liftProvider()
  {
    return [
      [
        function ($fst, $snd) {
          return $fst / $snd;
        },
        0,
        [null, 3],
      ],
      [
        function ($fst) {
          return $fst ** 2;
        },
        1,
        [null],
      ],
    ];
  }

  /**
   * @dataProvider liftProvider
   */
  public function testEitherIsLiftable($func, $def, $args)
  {
    $lifted = Either\Either::lift($func, Either\Either::left($def));
    $params = f\map(function ($arg) {
      return Either\Either::right($arg);
    }, $args);

    $this->assertInstanceOf(\Closure::class, $lifted);
    $this->assertInstanceOf(Either\Either::class, $lifted(...$params));
  }
}
