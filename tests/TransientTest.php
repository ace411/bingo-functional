<?php

declare(strict_types=1);

namespace Chemem\Bingo\Functional\Tests;

class TransientTest extends \PHPUnit\Framework\TestCase
{
    public function testTransientMutatorAllowsForControlledMutation()
    {
        $mike = new Money(14.0);
        $ted  = new Money(19.0);

        $sum = Money::sum($mike, $ted);

        $this->assertInternalType('float', $sum->getWallet());
        $this->assertInstanceOf(Money::class, $sum);
    }
}
