<?php

use PHPUnit\Framework\TestCase;
use Chemem\Bingo\Functional\Functors\Either\{Either, Left, Right};

class EitherTypeTest extends TestCase
{
    public function testEitherTypeLeftMethodReturnsLeftType()
    {
        $error = Either::left($GLOBALS['ERROR_MSG']);
        $this->assertInstanceOf(Left::class, $error);
    }

    public function testEitherTypeRightMethodReturnsRightType()
    {
        $val = Either::right(12);
        $this->assertInstanceOf(Right::class, $val);
    }

    public function testPartitionEithersReturnsLeftRightUnzippedList()
    {
        $eithers = [
            Either::right(12),
            Either::right(32),
            Either::left(false),
            Either::left('undefined')
        ];
        $partitionedEithers = Either::partitionEithers($eithers);
        $this->assertTrue(is_array($partitionedEithers));
        $this->assertEquals(
            $partitionedEithers,
            [
                'left' => [2 => false, 3 => 'undefined'],
                'right' => [12, 32]
            ]
        );
    }

    public function testEitherRightTypeValueIsRight()
    {
        $value = Either::right(12);

        $this->assertTrue($value->isRight());
        $this->assertFalse($value->isLeft());
    }

    public function testEitherLeftTypeValueIsLeft()
    {
        $error = Either::left($GLOBALS['ERROR_MSG']);

        $this->assertTrue($error->isLeft());
        $this->assertFalse($error->isRight());
    }

    public function testEitherRightTypeGetRightMethodReturnsRightValue()
    {
        $value = Either::right(12);

        $this->assertEquals($value->getRight(), 12);
        $this->assertEquals($value->getLeft(), null);
    }

    public function testEitherLeftTypeGetLeftMethodReturnsLeftValue()
    {
        $error = Either::left($GLOBALS['ERROR_MSG']);

        $this->assertEquals($error->getLeft(), $GLOBALS['ERROR_MSG']);
        $this->assertEquals($error->getRight(), null);
    }

    public function testEitherRightTypeFlatMapMethodReturnsNonEncapsulatedValue()
    {
        $value = Either::right(12)
            ->flatMap(
                function (int $a) : int {
                    return $a + 10;
                }
            );
        $this->assertEquals($value, 22);
    }

    public function testEitherRightTypeMapMethodReturnsEncapsulatedValue()
    {
        $value = Either::right(12)
            ->map(
                function (int $a) : int {
                    return $a + 10;
                }
            );
        $this->assertInstanceOf(Either::class, $value);
    }

    public function testEitherRightTypeFilterMethodReturnsEncapsulatedValueBasedOnPredicate()
    {
        $value = Either::right('foo')
            ->filter(
                function (string $str) : bool {
                    return is_string($str);
                },
                $GLOBALS['ERROR_MSG']
            );
        $this->assertInstanceOf(Right::class, $value);
        $this->assertEquals($value->getRight(), 'foo');
    }

    public function testEitherRightTypeFilterMethodReturnsLeftValueIfConditionEvaluatesToFalse()
    {
        $value = Either::right(12)
            ->filter(
                function (int $val) : bool {
                    return is_string($val);
                },
                $GLOBALS['ERROR_MSG']
            );
        $this->assertInstanceOf(Left::class, $value);
        $this->assertEquals($value->getLeft(), $GLOBALS['ERROR_MSG']);
    }

    public function testMapFlatMapFilterMethodsHaveNoEffectOnLeftValue()
    {
        $error = Either::left($GLOBALS['ERROR_MSG'])
            ->filter(
                function (string $val) : bool {
                    return is_string($val);
                },
                $GLOBALS['ERROR_MSG']
            )
            ->map(
                function (string $val) {
                    return $val . '//';
                }
            )
            ->flatMap(
                function (string $val) {
                    return $val . '..';
                }
            );
        $this->assertEquals($error, $GLOBALS['ERROR_MSG']);
    }
}
