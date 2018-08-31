<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Immutable\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testFromMethodCreatesNewCollectionInstance()
    {
        $this->assertInstanceOf(Collection::class, Collection::from(1, 2, 3, 4));
    }

    public function testMapFunctionCreatesNewCollectionInstance()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->map(function ($val) {
                return $val + 2;
            });

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testMapFunctionAppliesFunctionToAllValuesInList()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->map(function ($val) {
                return $val + 2;
            })
            ->getList();

        $this->assertEquals(\SplFixedArray::fromArray([3, 4, 5, 6]), $list);
    }

    public function testMapFunctionAppliesFunctionToAllValuesInArray()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->map(function ($val) {
                return $val + 2;
            });

        $this->assertEquals([3, 4, 5, 6], $list->toArray());
    }

    public function testFlatMapFunctionCreatesArray()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->flatMap(function ($val) {
                return $val * 2;
            });

        $this->assertInternalType('array', $list);
        $this->assertEquals([2, 4, 6, 8], $list);
    }

    public function testFlatMapFunctionAppliesFunctionToAllValuesInArray()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->flatMap(function ($val) {
                return $val * 2;
            });

        $this->assertInternalType('array', $list);
        $this->assertEquals([2, 4, 6, 8], $list);
    }

    public function testFilterFunctionCreatesNewCollectionInstance()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->filter(function ($val) {
                return $val > 2;
            });

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testFilterFunctionOutputsListOfValuesThatMatchFunctionBooleanPredicate()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->filter(function ($val) {
                return $val > 2;
            })
            ->getList();

        $this->assertEquals(\SplFixedArray::fromArray([3, 4]), $list);
    }

    public function testFoldFunctionCreatesNewCollectionInstance()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->fold(function ($acc, $val) {
                return $acc + $val;
            }, 1);

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testFoldFunctionTransformsListIntoSingleValue()
    {
        $list = Collection::from(1, 2, 3, 4)
            ->fold(function ($acc, $val) {
                return $acc + $val;
            }, 1)
            ->getList();

        $this->assertEquals(11, $list);
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
        $list = Collection::from(13, 15, 16, 18, 14, 20)
            ->filter(function ($val) {
                return $val % 2 == 0;
            });
        $acc = $list->toArray();

        $this->assertInternalType('array', $acc);
        $this->assertEquals([16, 18, 14, 20], $acc);
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

        $this->assertCount(2, $list);
    }

    public function testReverseMethodCreatesNewCollectionInstance()
    {
        $list = Collection::from(...range(0, 10))
            ->reverse();

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testReverseMethodCreatesNewCollectionToArray()
    {
        $list = Collection::from(...range(0, 10))
            ->reverse()
            ->toArray();

        $this->assertEquals([10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0], $list);
    }

    public function testReverseMethodReversesListOrder()
    {
        $list = Collection::from(...range(0, 10))
            ->map(function ($val) {
                return $val * 5;
            })
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

    public function testGetIterator()
    {
        $list = Collection::from(...range(0, 10))
            ->fill(1, 2, 3);
        $result = $list->getIterator();

        $this->assertInstanceOf(\ArrayIterator::class, $result);
        $this->assertSame([0, 1, 1, 1, 4, 5, 6, 7, 8, 9, 10], iterator_to_array($result));
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
