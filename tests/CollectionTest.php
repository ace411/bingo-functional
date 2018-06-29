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

        $this->assertEquals(\SplFixedArray::fromArray([11]), $list);
        $this->assertEquals($list->getSize(), 1);
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
}