<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Maybe\Just;
use Chemem\Bingo\Functional\Functors\Maybe\Maybe;
use Chemem\Bingo\Functional\Functors\Maybe\Nothing;
use PHPUnit\Framework\TestCase;

class MaybeTypeTest extends TestCase
{
    public function testMaybeTypeJustMethodReturnsJustType()
    {
        $val = Maybe::just(12);
        $this->assertInstanceOf(Just::class, $val);
    }

    public function testMaybeTypeNothingMethodReturnsNothingType()
    {
        $val = Maybe::nothing(12);
        $this->assertInstanceOf(Nothing::class, $val);
    }

    public function testMaybeTypeFromValueReturnsTypeFromValueDefinition()
    {
        $val = Maybe::fromValue(12);
        $another = Maybe::fromValue(12, 12);
        $yetAnother = Maybe::fromValue(null);

        $this->assertInstanceOf(Just::class, $val);
        $this->assertInstanceOf(Nothing::class, $another);
        $this->assertInstanceOf(Nothing::class, $yetAnother);
    }

    public function testMaybeJustTypeValueIsJust()
    {
        $val = Maybe::just(12);

        $this->assertTrue($val->isJust());
        $this->assertFalse($val->isNothing());
    }

    public function testMaybeOrElse()
    {
        $val = Maybe::just(12);
        $result = $val->orElse($val);

        $this->assertInstanceOf(Maybe::class, $result);
        $this->assertEquals(12, $result->getJust());
    }

    public function testMaybeNothingTypeValueIsNothing()
    {
        $val = Maybe::nothing();

        $this->assertTrue($val->isNothing());
        $this->assertFalse($val->isJust());
        $this->assertNull($val->getJust());
    }

    public function testMaybeLiftMethodChangesFunctionsToAcceptMaybeTypes()
    {
        $lifted = Maybe::lift(function (int $a, int $b) : int {
            return $a + $b;
        });

        $this->assertEquals(3, $lifted(Maybe::just(1), Maybe::just(2))->getJust());
    }

    public function testMaybeJustTypeGetJustMethodReturnsJustValue()
    {
        $val = Maybe::just(12);

        $this->assertEquals(12, $val->getJust());
        $this->assertEquals(null, $val->getNothing());
    }

    public function testMaybeJustTypeFlatMapMethodReturnsNonEncapsulatedValue()
    {
        $val = Maybe::just(12)
            ->flatMap(function (int $a) : int {
                return $a + 10;
            });

        $this->assertEquals(22, $val);
    }

    public function testMaybeJustTypeMapMethodReturnsEncapsulatedValue()
    {
        $val = Maybe::just(12)
            ->map(function (int $a) : int {
                return $a + 10;
            });

        $this->assertInstanceOf(Just::class, $val);
    }

    public function testMaybeJustTypeFilterMethodReturnsEncapsulatedValueBasedOnPredicate()
    {
        $val = Maybe::just('foo')
            ->filter(function (string $str) : bool {
                return is_string($str);
            });

        $this->assertInstanceOf(Just::class, $val);
        $this->assertEquals('foo', $val->getJust());
    }

    public function testMaybeJustTypeReturnsNothingIfConditionEvaluatesToFalse()
    {
        $val = Maybe::just(12)
            ->filter(
                function (int $val) : bool {
                    return is_string($val);
                }
            );
        $this->assertInstanceOf(Nothing::class, $val);
        $this->assertEquals(null, $val->getNothing());
    }

    public function testMapFlatMapFilterMethodsHaveNoEffectOnNothingValue()
    {
        $val = Maybe::nothing()
            ->filter(function ($val = null) {
                return is_null($val);
            })
            ->map(function ($val = null) : string {
                return 'null';
            })
            ->flatMap(function ($val = null) : string {
                return 'null';
            });

        $this->assertEquals(null, $val);
    }

    public function testOrElseMethodReturnsFinalMaybeTypeResult()
    {
        $val = Maybe::fromValue(12);

        $mutated = $val
            ->filter(function ($val) {
                return $val > 20;
            }, 0)
            ->map(function ($val) {
                return $val + 10;
            })
            ->orElse(Maybe::fromValue(25));

        $this->assertInstanceOf(Maybe::class, $mutated);
        $this->assertEquals(25, $mutated->getJust());
    }
}
