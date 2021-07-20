<?php

namespace Chemem\Bingo\Functional\Tests\Functors;

use Eris\Generator;
use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Tests as t;
use Chemem\Bingo\Functional\Functors\IdentityFunctor;
use Chemem\Bingo\Functional\Functors\ConstantFunctor;

class FunctorTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function IdentityFunctorObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\constant('foo')
      )
      ->then(function ($list) {
        $fx = 'strtoupper';
        $fy = f\partialRight(f\partial(f\concat, '-'), 'bar');

        $this->assertEquals(
          [
            'identity'    => true,
            'composition' => true,
          ],
          t\functorLaws(IdentityFunctor::of($item), $fx, $fy)
        );
      });
  }

  /**
   * @test
   */
  public function ConstantFunctorObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\constant('foo')
      )
      ->then(function ($list) {
        $fx = 'strtoupper';
        $fy = f\partialRight(f\partial(f\concat, '-'), 'bar');

        $this->assertEquals(
          [
            'identity'    => true,
            'composition' => true,
          ],
          t\functorLaws(ConstantFunctor::of($item), $fx, $fy)
        );
      });
  }
}
