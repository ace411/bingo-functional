<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Either\Either;
use Chemem\Bingo\Functional\Functors\Either\Left;
use Chemem\Bingo\Functional\Functors\Either\Right;
use PHPUnit\Framework\TestCase;
use function Chemem\Bingo\Functional\Algorithms\concat;
use function Chemem\Bingo\Functional\Algorithms\identity;
use function Chemem\Bingo\Functional\Functors\Either\either;
use function Chemem\Bingo\Functional\Functors\Either\fromLeft;
use function Chemem\Bingo\Functional\Functors\Either\fromRight;
use function Chemem\Bingo\Functional\Functors\Either\isLeft;
use function Chemem\Bingo\Functional\Functors\Either\isRight;
use function Chemem\Bingo\Functional\Functors\Either\lefts;
use function Chemem\Bingo\Functional\Functors\Either\partitionEithers;
use function Chemem\Bingo\Functional\Functors\Either\rights;

class EitherTypeTest extends TestCase
{
    public function testEitherTypeLeftMethodReturnsLeftType()
    {
        $error = Either::left($GLOBALS['ERR_MSG']);
        $this->assertInstanceOf(Left::class, $error);
    }

    public function testBindMethodEnablesSequentialFunctionChainOfRightType()
    {
        $either = Either::right(12)
            ->bind(function ($val) {
                return Either::right($val + 2);
            })
            ->bind(function ($val) {
                return Either::right(pow($val, 2));
            });

        $this->assertInstanceOf(Either::class, $either);
        $this->assertEquals(196, fromRight(0, $either));
    }

    public function testEitherTypeRightMethodReturnsRightType()
    {
        $val = Either::right(12);
        $this->assertInstanceOf(Right::class, $val);
    }

    public function testEitherRightTypeValueIsRight()
    {
        $value = Either::right(12);

        $this->assertTrue($value->isRight());
        $this->assertInstanceOf(Right::class, $value);
    }

    public function testEitherLeftTypeValueIsLeft()
    {
        $error = Either::left($GLOBALS['ERR_MSG']);

        $this->assertTrue($error->isLeft());
        $this->assertInstanceOf(Left::class, $error);
    }

    public function testEitherRightTypeGetRightMethodReturnsRightValue()
    {
        $value = Either::right(12);

        $this->assertEquals($value->getRight(), 12);
        $this->assertEquals($value->getLeft(), null);
    }

    public function testEitherLeftTypeGetLeftMethodReturnsLeftValue()
    {
        $error = Either::left($GLOBALS['ERR_MSG']);

        $this->assertEquals($error->getLeft(), $GLOBALS['ERR_MSG']);
        $this->assertEquals($error->getRight(), null);
    }

    public function testEitherRightTypeFlatMapMethodReturnsNonEncapsulatedValue()
    {
        $value = Either::right(12)
            ->flatMap(function (int $a) : int {
                return $a + 10;
            });

        $this->assertEquals($value, 22);
    }

    public function testEitherRightTypeMapMethodReturnsEncapsulatedValue()
    {
        $value = Either::right(12)
            ->map(function (int $a) : int {
                return $a + 10;
            });

        $this->assertInstanceOf(Either::class, $value);
        $this->assertEquals(22, $value->getRight());
    }

    public function testEitherRightTypeFilterMethodReturnsEncapsulatedValueBasedOnPredicate()
    {
        $value = Either::right('foo')
            ->filter(function (string $str) : bool {
                return is_string($str);
            }, $GLOBALS['ERR_MSG_STR']);

        $this->assertInstanceOf(Right::class, $value);
        $this->assertEquals('foo', $value->getRight());
    }

    public function testLiftMethodEnsuresFunctionsAcceptEitherTypeArguments()
    {
        $lift = Either::lift(function (int $a, int $b) {
            return $b / $a;
        }, Either::left(0));

        $this->assertInstanceOf(Either::class, $lift(Either::right(6), Either::right(12)));
        $this->assertEquals(2, $lift(Either::right(6), Either::right(12))->getRight());
    }

    public function testEitherRightTypeFilterMethodReturnsLeftValueIfConditionEvaluatesToFalse()
    {
        $value = Either::right(12)
            ->filter(function (int $val) : bool {
                return is_string($val);
            }, $GLOBALS['ERR_MSG_STR']);

        $this->assertInstanceOf(Left::class, $value);
        $this->assertEquals($GLOBALS['ERR_MSG_STR'], $value->getLeft());
    }

    public function testMapFlatMapFilterMethodsHaveNoEffectOnLeftValue()
    {
        $error = Either::left($GLOBALS['ERR_MSG'])
            ->filter(function (string $val) : bool {
                return is_string($val);
            }, $GLOBALS['ERR_MSG_STR'])
            ->map(function (string $val) {
                return concat('/', $val, '/');
            })
            ->flatMap(function (string $val) {
                return concat('.', $val, '.');
            });

        $this->assertEquals($GLOBALS['ERR_MSG'], $error);
    }

    public function testOrElseMethodReturnsFinalEitherTypeResult()
    {
        $val = Either::right(12);

        $mutated = $val
            ->filter(function ($val) {
                return $val > 20;
            }, identity(0))
            ->map(function ($val) {
                return $val + 10;
            })
            ->orElse(Either::right(25));

        $this->assertInstanceOf(Either::class, $mutated);
        $this->assertEquals(25, $mutated->getRight());
    }

    public function testEitherFunctionPerformsCaseAnalysisOnEitherType()
    {
        $either = either(
            'strtoupper',
            function (int $val) {
                return (144 / $val) * 2;
            },
            Either::left('Cannot divide by zero')
        );

        $this->assertEquals('CANNOT DIVIDE BY ZERO', $either);
        $this->assertInternalType('string', $either);
    }

    public function testIsLeftAndIsRightFunctionsEvaluateToBooleanValues()
    {
        $left = Left::of(12);

        $this->assertEquals(true, isLeft($left));
        $this->assertEquals(false, isRight($left));
        $this->assertInternalType('boolean', isLeft($left));
    }

    public function testLeftsAndRightsFunctionsExtractFromAListOfEithersAllLeftAndRightValuesRespectively()
    {
        $eithers = [Left::of(1), Right::of(13), Right::of(22)];

        $this->assertEquals([1], lefts($eithers));
        $this->assertEquals([13, 22], rights($eithers));
        $this->assertInternalType('array', rights($eithers));
        $this->assertInternalType('array', lefts($eithers));
    }

    public function testFromRightFunctionOutputsRightValueIfEitherIsRightOrDefaultValueOtherwise()
    {
        $this->assertEquals(33, fromRight(33, Either::left(12)));
        $this->assertEquals(2, fromRight(4, Either::right(2)));
    }

    public function testFromLeftFunctionOutputsLeftValueIfEitherIsLeftOrDefaultValueOtherwise()
    {
        $this->assertEquals(2, fromLeft(22, Either::left(2)));
        $this->assertEquals(22, fromLeft(22, Either::right(14)));
    }

    public function testPartitionEithersFunctionPartitionsListOfEithersIntoTwoLists()
    {
        $eithers = partitionEithers([Either::left(12), Either::right(2), Either::left(19)]);

        $this->assertInternalType('array', $eithers);
        $this->assertEquals(['left' => [12, 19], 'right' => [2]], $eithers);
    }
}
