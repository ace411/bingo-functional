<?php

namespace Chemem\Bingo\Functional\Tests;

use PHPUnit\Framework\TestCase;
use Chemem\Bingo\Functional\Immutable\Collection;

class CollectionTest extends TestCase
{
    public function testFromMethodCreatesNewCollectionInstance()
    {
        $this->assertInstanceOf(Collection::class, Collection::from(1, 2, 3, 4));
    }

    public function testMapFunctionCreatesNewCollectionInstance()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->map(function ($val) { return $val + 2; });

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testMapFunctionAppliesFunctionToAllValuesInList()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->map(function ($val) { return $val + 2; })
            ->getList();

        $this->assertEquals(\SplFixedArray::fromArray([3, 4, 5, 6]), $list);
    }

    public function testFlatMapFunctionCreatesArray()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->flatMap(function ($val) { return $val * 2; });

        $this->assertInternalType('array', $list);
    }

    public function testFlatMapFunctionAppliesFunctionToAllValuesInList()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->flatMap(function ($val) { return $val * 2; });

        $this->assertEquals([2, 4, 6, 8], $list);
    }

    public function testFilterFunctionCreatesNewCollectionInstance()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->filter(function ($val) { return $val > 2; });

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testFilterFunctionOutputsListOfValuesThatMatchFunctionBooleanPredicate()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->filter(function ($val) { return $val > 2; })
            ->getList();
            
        $this->assertEquals(\SplFixedArray::fromArray([3, 4]), $list);
    }

    public function testFoldFunctionCreatesNewCollectionInstance()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->fold(function ($acc, $val) { return $acc + $val; }, 1);

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testFoldFunctionTransformsListIntoSingleValue()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->fold(function ($acc, $val) { return $acc + $val; }, 1)
            ->getList();
            
        $this->assertEquals($list, 11);
    }

    public function testMergeFunctionCreatesNewCollectionInstance()
    {
        $combined = Collection::from(1, 2)
            ->merge(Collection::from(3, 4));

        $this->assertInstanceOf(Collection::class, $combined);
    }

    public function testMergeFunctionCombinesLists()
    {
        $combined = Collection::from(1, 2)
            ->merge(Collection::from(3, 4))
            ->getList();
            
        $this->assertEquals(\SplFixedArray::fromArray([1, 2, 3, 4]), $combined);
    }

    public function testSliceFunctionCreatesNewCollectionInstance()
    {
        $sliced = Collection::from('foo', 'bar', 'baz')
            ->slice(2);

        $this->assertInstanceOf(Collection::class, $sliced);
    }

    public function testSliceFunctionRemovesSpecifiedNumberOfElementsFromFrontOfList()
    {
        $sliced = Collection::from('foo', 'bar', 'baz')
            ->slice(2)
            ->getList();

        $this->assertEquals(\SplFixedArray::fromArray(['baz']), $sliced);
    }

    public function testCollectionInstanceIsJsonSerializable()
    {
        $list = Collection::from('foo', 'bar', 'baz')
            ->map('strtoupper');

        $this->assertContains('JsonSerializable', class_implements($list));
        $this->assertInternalType('string', json_encode($list));
    }

    public function testCollectionImplementsIteratorAggregate()
    {
        $list = Collection::from('FOO', 'BAR')
            ->map('strtolower');

        $this->assertContains('IteratorAggregate', class_implements($list));
    }

    public function testCollectionClassIsIterable()
    {
        $acc = [];
        $list = Collection::from(13, 15, 16, 18, 14, 20)
            ->filter(function ($val) { return $val % 2 == 0; });

        foreach ($list as $val) {
            if ($val < 15) {
                $acc[] = $val;
            }
        }

        $this->assertInternalType('array', $acc);
        $this->assertEquals([14], $acc);
    }

    public function testCollectionImplementsCountable()
    {
        $list = Collection::from('foo', 'bar')
            ->map('strtoupper');

        $this->assertContains('Countable', class_implements($list));
    }

    public function testCollectionIsCountable()
    {
        $list = Collection::from('foo', 'bar')
            ->map('strtoupper');
            
        $this->assertEquals(2, count($list));
    }

    public function testReverseMethodCreatesNewCollectionInstance()
    {
        $list = Collection::from(...range(0, 10))
            ->reverse();

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testReverseMethodReversesListOrder()
    {
        $list = Collection::from(...range(0, 10))
            ->map(function ($val) { return $val * 5; })
            ->reverse()
            ->getList();

        $this->assertEquals(
            \SplFixedArray::fromArray([50, 45, 40, 35, 30, 25, 20, 15, 10, 5, 0]),
            $list
        );
    }

    public function testFillMethodCreatesNewCollectionInstance()
    {
        $list = Collection::from(...range(0, 10))
            ->fill('foo', 2, 5);

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testFillMethodOutputsListWithArbitraryValuesAffixedToDefinedIndexes()
    {
        $list = Collection::from(...range(1, 10))
            ->fill('foo', 2, 5)
            ->getList();

        $this->assertEquals(
            \SplFixedArray::fromArray([1, 2, 'foo', 'foo', 'foo', 'foo', 7, 8, 9, 10]),
            $list
        );
    }
}