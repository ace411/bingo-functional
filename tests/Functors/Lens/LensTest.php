<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Lens;

\error_reporting(0);

use Eris\Generator;
use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Functors\Lens as l;
use Chemem\Bingo\Functional\Tests as t;

class LensTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function LensObeysLensLaws()
  {
    $this
      ->forAll(
        Generator\associative([
          'foo' => Generator\string(),
          'bar' => Generator\int(),
          'baz' => Generator\names(),
        ]),
        Generator\float()
      )
      ->then(function ($list, $val) {
        $laws = t\lensLaws(
          f\partialRight(f\pluck, 'foo'),
          f\curry(f\assoc)('foo'),
          $list,
          $val
        );

        $this->assertEquals([
          'first'   => true,
          'second'  => true,
          'third'   => true,
        ], $laws);
      });
  }

  /**
   * @test
   */
  public function lensObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\associative([
          'foo' => Generator\string(),
          'bar' => Generator\int(),
          'baz' => Generator\names(),
        ])
      )
      ->then(function ($store) {
        $laws = t\lensFunctorLaws(
          f\partialRight(f\pluck, 'foo'),
          f\curry(f\assoc)('foo'),
          $store,
          'strtoupper',
          'lcfirst'
        );

        $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], $laws);
      });
  }

  public function lensPathProvider()
  {
    return [
      [
        ['foo', 0],
        ['foo' => \range(1, 3)],
        1,
      ],
      [
        [0, 'bar', 'baz'],
        [['bar' => ['baz' => \range(1, 2)]]],
        \range(1, 2),
      ],
    ];
  }

  /**
   * @dataProvider lensPathProvider
   */
  public function testlensPathCreatesLensFromTraversablePath($path, $store, $res)
  {
    $lens = l\lensPath(...$path);

    $this->assertInstanceOf(\Closure::class, $lens);
    $this->assertEquals($res, l\view($lens, $store));
  }

  public function lensKeyProvider()
  {
    return [
      ['bar', ['foo' => 'fooz', 'bar' => 'baz'], 'baz'],
      [1, \range(4, 7), 5],
    ];
  }

  /**
   * @dataProvider lensKeyProvider
   */
  public function testlensKeyCreatesLensWhoseFocalPointIsArbitraryListKey($key, $store, $res)
  {
    $lens = l\lensKey($key);

    $this->assertInstanceOf(\Closure::class, $lens);
    $this->assertEquals($res, l\view($lens, $store));
  }
}
