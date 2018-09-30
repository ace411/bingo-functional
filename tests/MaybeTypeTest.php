<?php

use PHPUnit\Framework\TestCase;
use Chemem\Bingo\Functional\Functors\Maybe\{Maybe, Just, Nothing};
use function \Chemem\Bingo\Functional\Algorithms\toException;
use function Chemem\Bingo\Functional\Functors\Maybe\{
    maybe,
    isJust,
    isNothing,
    fromJust,
    fromMaybe,
    listToMaybe,
    maybeToList,
    catMaybes,
    mapMaybe
};

class MaybeTypeTest extends TestCase
{
    public function testMaybeTypeJustMethodReturnsJustType()
    {
        $val = Maybe::just(12);
        $this->assertInstanceOf(Just::class, $val);
    }

    public function testBindMethodEnablesSequentialChainOfJustType()
    {
        $maybe = Maybe::fromValue(2)
            ->bind(function ($val) {
                return Just::of($val * 2);
            })
            ->bind(function ($val) {
                return Just::of($val / 4);
            });

        $this->assertInstanceOf(Maybe::class, $maybe);
        $this->assertEquals(1, fromMaybe(0, $maybe));
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

    public function testMaybeNothingTypeValueIsNothing()
    {
        $val = Maybe::nothing();

        $this->assertTrue($val->isNothing());
        $this->assertFalse($val->isJust());
    }

    public function testMaybeLiftMethodChangesFunctionsToAcceptMaybeTypes()
    {
        $lifted = Maybe::lift(function (int $a, int $b) : int { return $a + $b; });

        $this->assertEquals(3, $lifted(Just::of(1), Just::of(2))->getJust());
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
            ->flatMap(function (int $a) : int { return $a + 10; });

        $this->assertEquals(22, $val);
    }

    public function testMaybeJustTypeMapMethodReturnsEncapsulatedValue()
    {
        $val = Just::of(12)
            ->map(function (int $a) : int { return $a + 10; });

        $this->assertInstanceOf(Just::class, $val);
    }

    public function testMaybeJustTypeFilterMethodReturnsEncapsulatedValueBasedOnPredicate()
    {
        $val = Just::of('foo')
            ->filter(function (string $str) : bool { return is_string($str); });
        
        $this->assertInstanceOf(Just::class, $val);
        $this->assertEquals('foo', $val->getJust());
    }

    public function testMaybeJustTypeReturnsNothingIfConditionEvaluatesToFalse()
    {
        $val = Just::of(12)
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
        $val = Nothing::of()
            ->filter(function ($val = null) { return is_null($val); })
            ->map(function ($val = null) : string { return "null"; })
            ->flatMap(function ($val = null) : string { return "null"; });

        $this->assertEquals(null, $val);
    }

    public function testOrElseMethodReturnsFinalMaybeTypeResult()
    {
        $val = Maybe::fromValue(12);

        $mutated = $val
            ->filter(function ($val) { return $val > 20; }, 0)
            ->map(function ($val) { return $val + 10; })
            ->orElse(Maybe::fromValue(25));

        $this->assertInstanceOf(Maybe::class, $mutated);
        $this->assertEquals(25, $mutated->getJust());
    }

    public function testMaybeFunctionAppliesFunctionToValueInsideJustAndReturnsDefaultValueIfNothing()
    {
        $maybe = maybe(
            12,
            function ($val) : int {
                return ($val * 2) / 4;
            },
            Maybe::fromValue(12)
        );

        $this->assertEquals(6, $maybe);
        $this->assertInternalType('integer', $maybe);
    }

    public function testIsJustAndIsNothingFunctionsEvaluateToBoolean()
    {
        $this->assertEquals(true, isJust(Maybe::fromValue(18)));
        $this->assertEquals(true, isNothing(Nothing::of()));
    }

    public function testFromJustExtractsOutputFromJustIfJustValueIsSuppliedAndThrowsAnExceptionOtherwise()
    {
        $this->assertEquals(12, fromJust(Maybe::fromValue(12)));
        $this->assertEquals(
            'Maybe.fromJust: Nothing', 
            toException(\Chemem\Bingo\Functional\Functors\Maybe\fromJust)(Nothing::of())
        );
    }

    public function testFromMaybeFunctionReturnsDefaultValueIfMaybeIsNothingAndJustValueOtherwise()
    {
        $this->assertEquals(0, fromMaybe(0, Nothing::of()));
        $this->assertEquals(12, fromMaybe(1, Maybe::fromValue(12)));
    }

    public function testListToMaybeFunctionReturnsNothingOnEmptyListOrJustTypeWithFirstListElement()
    {
        $this->assertInstanceOf(Nothing::class, listToMaybe([]));
        $this->assertInstanceOf(Just::class, listToMaybe(range(1, 3)));   
    }

    public function testMaybeToListReturnsAnEmptyListWhenSuppliedNothingAndSingletonListOtherwise()
    {
        $this->assertEquals([], maybeToList(Maybe::nothing()));
        $this->assertEquals([19], maybeToList(Maybe::fromValue(19)));
    }

    public function testCatMaybesTakesListOfMaybesAndReturnsListOfJustValues()
    {
        $this->assertEquals(['foo', 'bar'], catMaybes([Maybe::fromValue('foo'), Maybe::fromValue('bar')]));
        $this->assertEquals([], catMaybes([Maybe::nothing(), Maybe::nothing()]));
    }

    public function testMapMaybeIsVersionOfMapAndThrowsOutElements()
    {
        $map = mapMaybe(
            function (string $value) {
                return Maybe::fromValue(strtoupper($value));
            },
            ['foo', 'bar']
        );

        $this->assertEquals(['FOO', 'BAR'], $map);
        $this->assertInternalType('array', $map);
    }
}