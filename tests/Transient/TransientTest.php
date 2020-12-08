<?php

namespace Chemem\Bingo\Functional\Tests\Transient;

\error_reporting(0);

use \Eris\Generator;
use Chemem\Bingo\Functional\Common\Traits\TransientMutator as Transient;

class TransientTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function TransientMutatorEnablesControlledMutation()
  {
    $this
      ->forAll(
        Generator\constant(0.0),
        Generator\float()
      )
      ->then(function (float $base, float $val) {
        $fst = new Money($base);
        $snd = new Money($val);

        $sum = Money::sum($fst, $snd);

        $this->assertIsFloat($sum->getWallet());
        $this->assertInstanceOf(Money::class, $sum);
        $this->assertEquals([
          Transient::class => Transient::class,
        ], \class_uses(__NAMESPACE__ . '\\Money'));
      });
  }
}
