<?php

namespace Chemem\Bingo\Functional\Tests\Immutable;

\error_reporting(0);

use Eris\Generator;
use Chemem\Bingo\Functional\Algorithms as f;
use Chemem\Bingo\Functional\Immutable\Tuple;
use Chemem\Bingo\Functional\Immutable as imm;

class TupleTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function containsChecksIfValueExistsInTuple()
  {
    $this
      ->forAll(
        Generator\tuple(
          Generator\constant('lib'),
          Generator\int(),
          Generator\names()
        )
      )
      ->then(function ($list) {
        $lst = Tuple::from($list);

        $this->assertIsBool($lst->contains('lib'));
        $this->assertIsBool($lst->contains('bingo_functional'));
      });
  }

  /**
   * @test
   */
  public function headOutputsFirstElementInTuple()
  {
    $this
      ->forAll(
        Generator\tuple(
          Generator\constant('foo'),
          Generator\int()
        )
      )
      ->then(function ($list) {
        $fst = Tuple::from($list)->head();

        $this->assertEquals('foo', $fst);
      });
  }

  /**
   * @test
   */
  public function lastOutputsLastElementInTuple()
  {
    $this
      ->forAll(
        Generator\tuple(
          Generator\int(),
          Generator\constant('foo')
        )
      )
      ->then(function ($list) {
        $lst = Tuple::from($list)->last();

        $this->assertEquals('foo', $lst);
      });
  }

  /**
   * @test
   */
  public function tailOutputsAllTupleElementsButTheFirst()
  {
    $this
      ->forAll(
        Generator\tuple(
          Generator\int(),
          Generator\string(),
          Generator\float()
        )
      )
      ->then(function ($list) {
        $lst = Tuple::from($list)->tail();

        $this->assertInstanceOf(Tuple::class, $lst);
        $this->assertEquals(2, \count($lst));
      });
  }

  /**
   * @test
   */
  public function fstExtractsFirstComponentOfTuplePair()
  {
    $this
      ->forAll(
        Generator\tuple(
          Generator\int(),
          Generator\constant('foo'),
          Generator\float()
        )
      )
      ->then(function ($list) {
        $fst = f\toException(function ($list) {
          return Tuple::from($list)->fst();
        });

        // extract error from failed pair creation
        $this->assertEquals(imm\TupleException::PAIR_ERRMSG, $fst($list));
        $this->assertEquals('foo', $fst(f\dropLeft($list, 1)));
      });
  }

  /**
   * @test
   */
  public function sndExtractsSecondComponentOfTuplePair()
  {
    $this
      ->forAll(
        Generator\tuple(
          Generator\int(),
          Generator\string(),
          Generator\constant(9)
        )
      )
      ->then(function ($list) {
        $snd = f\toException(function ($list) {
          return Tuple::from($list)->snd();
        });

        $this->assertEquals(imm\TupleException::PAIR_ERRMSG, $snd($list));
        $this->assertEquals(9, $snd(f\dropLeft($list, 1)));
      });
  }

  /**
   * @test
   */
  public function swapInvertsTuplePairOrder()
  {
    $this
      ->forAll(
        Generator\tuple(
          Generator\int(),
          Generator\constant('foo'),
          Generator\constant('bar')
        )
      )
      ->then(function ($list) {
        $swap = f\toException(function ($list) {
          return Tuple::from($list)->swap();
        });
        $data = $swap(f\dropLeft($list, 1));

        $this->assertEquals(imm\TupleException::PAIR_ERRMSG, $swap($list));
        $this->assertEquals('bar', $data->get(0));
        $this->assertEquals('foo', $data->get(1));
      });
  }
}
