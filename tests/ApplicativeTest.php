<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Common\Applicatives\ApplicativeAbstract;
use Chemem\Bingo\Functional\Functors\Applicatives\Applicative;
use Chemem\Bingo\Functional\Functors\Applicatives\CollectionApplicative;
use PHPUnit\Framework\TestCase;

class ApplicativeTest extends TestCase
{
    public function testApplicativePureMethodAddsValueToApplicativeFunctor()
    {
        $value = Applicative::pure('foo');
        $this->assertInstanceOf(ApplicativeAbstract::class, $value);
    }

    public function testApplicativeApplyMethodMapsValueOntoApplicativeCallable()
    {
        $addTen = function (int $a) : int {
            return $a + 10;
        };
        $add = Applicative::pure($addTen)
            ->apply(Applicative::pure(12));

        $this->assertInstanceOf(ApplicativeAbstract::class, $add);
        $this->assertEquals($add->getValue(), 22);
    }

    public function testApplicativeApplyMethodMapsCollectionApplicativeOntoApplicativeCallable()
    {
        $reduce = function (array $values) : int {
            return array_reduce(
                $values,
                function ($acc, $val) {
                    return $acc + $val;
                },
                0
            );
        };
        $reduced = Applicative::pure($reduce)
            ->apply(CollectionApplicative::pure([1, 2, 3]))
            ->getValue();
        $this->assertEquals($reduced, 6);
    }

    public function testCollectionApplicativePureMethodReturnsApplicativeList()
    {
        $prime = CollectionApplicative::pure(2);
        $odd = CollectionApplicative::pure([1, 3, 5]);

        $this->assertInstanceOf(ApplicativeAbstract::class, $odd);
        $this->assertInstanceOf(ApplicativeAbstract::class, $prime);
        $this->assertEquals($prime->getValues(), [2]);
        $this->assertEquals($odd->getValues(), [1, 3, 5]);
        $this->assertTrue(
            is_array($prime->getValues()) &&
            is_array($odd->getValues())
        );
    }

    public function testCollectionApplicativeApplyMethodReturnsZipList()
    {
        $zipList = CollectionApplicative::pure([
            function (int $a) : int {
                return $a + 10;
            },
            function (int $b) : int {
                return $b * 10;
            },
        ])
        ->apply(CollectionApplicative::pure([1, 2, 3]));

        $this->assertInstanceOf(ApplicativeAbstract::class, $zipList);
        $this->assertEquals(
            $zipList->getValues(),
            [11, 12, 13, 10, 20, 30]
        );
    }
}
