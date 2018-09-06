<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Either\Either;
use Chemem\Bingo\Functional\Functors\Either\Left;
use Chemem\Bingo\Functional\Functors\Either\Right;
use PHPUnit\Framework\TestCase;
use function Chemem\Bingo\Functional\Algorithms\concat;
use function Chemem\Bingo\Functional\Algorithms\identity;

class EitherTypeTest extends TestCase
{
    public function testEitherTypeLeftMethodReturnsLeftType()
    {
        $error = Either::left($GLOBALS['ERR_MSG']);
        $this->assertInstanceOf(Left::class, $error);
    }

    public function testEitherTypeRightMethodReturnsRightType()
    {
        $val = Either::right(12);
        $this->assertInstanceOf(Right::class, $val);
    }

    public function testEitherRightTypeBindMethod()
    {
        $val = Either::right(12);
        $result = $val->bind(function ($val) {
            return $val * 2;
        });

        $this->assertEquals(24, $result->getRight());
    }

    public function testEitherLeftTypeIsRightMethod()
    {
        $val = Either::left(12);

        $this->assertFalse($val->isRight());
    }

    public function testEitherLeftTypeBindMethod()
    {
        $val = Either::left(12);
        $result = $val->bind(function ($val) {
            return false;
        });

        $this->assertEquals(12, $result->getLeft());
    }

    public function testPartitionEithersReturnsLeftRightUnzippedList()
    {
        $eithers = Either::partitionEithers([
            Either::right(12),
            Either::right(32),
            Either::left(false),
            Either::left('undefined'),
        ]);

        $this->assertInternalType('array', $eithers);
        $this->assertEquals(
            [
                'left'  => [false, 'undefined'],
                'right' => [12, 32],
            ],
            $eithers
        );
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
}
