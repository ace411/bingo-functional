<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Monads;

\error_reporting(0);

use \Eris\Generator;
use Chemem\Bingo\Functional\{
  Functors\Applicatives\Applicative as Ap,
  Algorithms as f,
  Tests as t
};

class ApplicativeTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function ApplicativeObeysApplicativeLaws()
  {
    $this
      ->forAll(
        Generator\choose(1, 80)
      )
      ->then(function ($input) {
        $app = Ap\pure(f\identity);

        $this->assertEquals([
          'identity'      => true,
          'interchange'   => true,
          'homomorphism'  => true,
          'composition'   => true,
          'map'           => true,
        ], t\applicativeLaws($app, function ($val) {
          return $val ** 2;
        }, $input));
      });
  }

  /**
   * @test
   */
  public function ApplicativeObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\string()
      )
      ->then(function ($input) {
        $app = Ap::of($input);

        $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], t\functorLaws($app, 'strtoupper', 'lcfirst'));
      });
  }

  public function liftA2Provider()
  {
    return [
      [
        function ($fst, $snd) {
          return ($fst * 3) / $snd;
        },
        [12, 2],
        18,
      ],
      [
        function ($fst, $snd, $thd) {
          return ($fst + $snd) / $thd;
        },
        [12, 10, 2],
        11,
      ],
    ];
  }

  /**
   * @dataProvider liftA2Provider
   */
  public function testliftA2LiftsBinaryFunctionIntoApplicativeActions($func, $args, $res)
  {
    $lift = Ap\liftA2($func, ...f\map(function ($arg) {
      return Ap\pure($arg);
    }, $args));

    $this->assertInstanceOf(Ap::class, $lift);
    $this->assertEquals($res, $lift->getValue());
  }
}
