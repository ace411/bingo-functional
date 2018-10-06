<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Applicatives\Applicative as Ap;

class ApplicativeTest extends \PHPUnit\Framework\TestCase
{
    public function testApplicativePureMethodAddsValueToApplicativeFunctor()
    {
        $value = Ap::pure('foo');
        $this->assertInstanceOf(Ap::class, $value);
    }

    public function testApplicativeApplyMethodMapsValueOntoApplicativeCallable()
    {
        $app = Ap::pure(function ($val) {
            return $val * 2;
        })
            ->ap(Ap::pure(12))
            ->getValue();

        $this->assertEquals(24, $app);
    }

    public function testMapMethodAppliesCallbackToValueDefinedInApplicativeContext()
    {
        $app = Ap::pure('foo')
            ->map('strtoupper')
            ->getValue();

        $this->assertEquals('FOO', $app);
    }

    public function testMapMethodOutputsApplicativeInstance()
    {
        $app = Ap::pure('foo')
            ->map('strtoupper');

        $this->assertInstanceOf(Ap::class, $app);
    }

    public function testPureHelperFunctionLiftsValue()
    {
        $app = Ap\pure(12);

        $this->assertInstanceOf(Ap::class, $app);
    }

    public function testLiftA2HelperFunctionLiftsBinaryFunctionIntoActions()
    {
        $lift = Ap\liftA2(
            function ($x, $y) {
                return ($x * 3) / $y;
            },
            Ap\pure(12),
            Ap\pure(2)
        );

        $this->assertInstanceOf(Ap::class, $lift);
        $this->assertEquals(18, $lift->getValue());
    }
}
