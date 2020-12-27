<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Monads;

\error_reporting(0);

use \Eris\Generator;
use Chemem\Bingo\Functional\Functors\Monads\ListMonad as Listt;
use Chemem\Bingo\Functional\Tests as t;

class ListMonadTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function ListMonadObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\tuple(
          Generator\choose(1, 5),
          Generator\choose(6, 10),
          Generator\choose(11, 15)
        )
      )
      ->then(function ($list) {
        $monad  = Listt::of($list);
        $fnx    = function ($res) {
          return $res ** 2;
        };
        $fny    = function ($res) {
          return $res + 10;
        };

        $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], t\functorLaws($monad, $fnx, $fny));
      });
  }

  /**
   * @test
   */
  public function ListMonadObeysMonadLaws()
  {
    $this
      ->forAll(
          Generator\int()
      )
      ->then(function ($val) {
        $list = Listt\fromValue($val);

        $fnx = function ($val) {
          return Listt::of($val ** 2);
        };

        $fny = function ($val) {
          return Listt::of($val + 10);
        };

        $this->assertEquals(
          [
            'left-identity'   => true,
            'right-identity'  => true,
            'associativity'   => true,
          ],
          t\monadLaws(
            $list,
            $fnx,
            $fny,
            Listt::of,
            $val
          )
        );
      });
  }

  public function concatProvider()
  {
    return [
      [[Listt\fromValue(2), Listt\fromValue(4), Listt\fromValue(9)], [2, 4, 9]],
      [[Listt\fromValue('foo'), Listt\fromValue(2.2)], ['foo', 2.2]],
    ];
  }

  /**
   * @dataProvider concatProvider
   */
  public function testConcatMergesMultipleListMonadInstances($args, $res)
  {
    $concat = Listt\concat(...$args);

    $this->assertInstanceOf(Listt::class, $concat);
    $this->assertEquals($res, $concat->extract());
  }
  
  public function prependProvider()
  {
    return [
      [[Listt::of(2), Listt::of(9)], [2, 9]],
      [
        [
          Listt::of('foo'),
          Listt::of([9, new \stdClass(1)]),
        ],
        ['foo', 9, new \stdClass(1)],
      ],
    ];
  }

  /**
   * @dataProvider prependProvider
   */
  public function testprependInsertsItemsFromOneListIntoBeginningOfAnother($args, $res)
  {
    $list = Listt\prepend(...$args);

    $this->assertEquals($res, $list->extract());
  }

  public function appendProvider()
  {
    return [
      [[Listt::of(2), Listt::of(9)], [9, 2]],
      [
        [
          Listt::of('foo'),
          Listt::of([9, new \stdClass(1)]),
        ],
        [9, new \stdClass(1), 'foo'],
      ],
    ];
  }

  /**
   * @dataProvider appendProvider
   */
  public function testappendAddsItemOfOneListToEndOfAnother($args, $res)
  {
    $list = Listt\append(...$args);

    $this->assertEquals($res, $list->extract());
  }

  public function headtailProvider()
  {
    return [
      [Listt::of(3)],
      [Listt::of(\range(1, 3))],
    ];
  }

  /**
   * @dataProvider headtailProvider
   */
  public function testheadReturnsFirstElementInList($list)
  {
    $head = Listt\head($list);

    $this->assertEquals($list->extract(), $head);
  }

  /**
   * @dataProvider headtailProvider
   */
  public function testtailReturnsMonoid($list)
  {
    $tail = Listt\tail($list);

    $this->assertIsObject($tail);
    $this->assertEquals(null, $tail->value);
  }
}
