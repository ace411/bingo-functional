<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Either;

\error_reporting(0);

use Eris\Generator;
use Chemem\Bingo\Functional\Tests as t;
use Chemem\Bingo\Functional\Functors\Monads\Either;
use Chemem\Bingo\Functional\Functors\Monads\Right;
use Chemem\Bingo\Functional\Functors\Monads\Left;
use Chemem\Bingo\Functional as f;

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
          Either::right($val) :
          Either::left($const);

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
          Either::right($res) :
          Either::left($const);
        $fnx    = function ($str) use ($right, $const) {
          $expr = f\concat(': ', 'name', $str);

          return $right ?
            Either::right($expr) :
            Either::left($const);
        };

        $fny    = function ($str) use ($right, $const) {
          $expr = f\toWords($str, '/([\s:])+/');

          return $right ?
            Either::right($expr) :
            Either::left($const);
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
            $right ? Right::of : Left::of,
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

    $rval = Either\either($left, $right, Right::of($argr));
    $lval = Either\either($left, $right, Left::of($argl));

    $this->assertEquals($lres, $lval);
    $this->assertEquals($rres, $rval);
  }

  public function leftsProvider()
  {
    return [
      [
        [Right::of(3), Left::of(0), Left::of('foo')],
        [0, 'foo'],
      ],
      [
        [Right::of('foo'), Left::of('bar')],
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
      [Left::of(2), null, 2],
      [Right::of('foo'), 'undefined', 'undefined'],
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
      [Left::of(2), 0, 0],
      [Right::of('foo'), null, 'foo'],
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
        [Left::of(2), Right::of('foo'), Left::of(9)],
        ['left' => [2, 9], 'right' => ['foo']],
      ],
      [
        [Right::of(2), Right::of('foo'), Left::of(9)],
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
}
