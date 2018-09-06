<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Applicatives\Applicative;

class ApplicativeTest extends \PHPUnit\Framework\TestCase
{
    public function testApplicativePureMethodAddsValueToApplicativeFunctor()
    {
        $value = Applicative::pure('foo');
        $this->assertInstanceOf(Applicative::class, $value);
    }

    public function testApplicativeApplyMethodMapsValueOntoApplicativeCallable()
    {
        $app = Applicative::pure(function ($val) {
            return $val * 2;
        })
            ->ap(Applicative::pure(12))
            ->getValue();

        $this->assertEquals(24, $app);
    }

    public function testApplicativeOfShouldReturnGivenValue()
    {
        $app = Applicative::of(12)
            ->getValue();

        $this->assertEquals(12, $app);
    }

    public function testMapMethodAppliesCallbackToValueDefinedInApplicativeContext()
    {
        $app = Applicative::pure('foo')
            ->map('strtoupper')
            ->getValue();

        $this->assertEquals('FOO', $app);
    }

    public function testMapMethodOutputsApplicativeInstance()
    {
        $app = Applicative::pure('foo')
            ->map('strtoupper');

        $this->assertInstanceOf(Applicative::class, $app);
    }
}
