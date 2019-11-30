<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Immutable\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testFromMethodCreatesNewCollectionInstance()
    {
        $this->assertInstanceOf(Collection::class, Collection::from([1, 2, 3, 4]));
    }

    public function testMapFunctionCreatesNewCollectionInstance()
    {
        $list = Collection::from([1, 2, 3, 4])
            ->map(function ($val) {
                return $val + 2;
            });

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testMapFunctionAppliesFunctionToAllValuesInList()
    {
        $list = Collection::from([1, 2, 3, 4])
            ->map(function ($val) {
                return $val + 2;
            })
            ->getList();

        $this->assertEquals(\SplFixedArray::fromArray([3, 4, 5, 6]), $list);
    }

    public function testMapFunctionAppliesFunctionToAllValuesInArray()
    {
        $list = Collection::from(range(1, 4))
            ->map(function ($val) {
                return $val + 2;
            });

        $this->assertEquals([3, 4, 5, 6], $list->toArray());
    }

    public function testFlatMapFunctionCreatesArray()
    {
        $list = Collection::from(range(1, 4))
            ->flatMap(function ($val) {
                return $val * 2;
            });

        $this->assertInternalType('array', $list);
        $this->assertEquals([2, 4, 6, 8], $list);
    }

    public function testFlatMapFunctionAppliesFunctionToAllValuesInArray()
    {
        $list = Collection::from(range(1, 4))
            ->flatMap(function ($val) {
                return $val * 2;
            });

        $this->assertInternalType('array', $list);
        $this->assertEquals([2, 4, 6, 8], $list);
    }

    public function testFilterFunctionCreatesNewCollectionInstance()
    {
        $list = Collection::from(range(1, 4))
            ->filter(function ($val) {
                return $val > 2;
            });

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testFilterFunctionOutputsListOfValuesThatMatchFunctionBooleanPredicate()
    {
        $list = Collection::from(range(1, 4))
            ->filter(function ($val) {
                return $val > 2;
            })
            ->getList();

        $this->assertEquals(\SplFixedArray::fromArray([3, 4]), $list);
    }

    public function testFoldFunctionTransformsCollectionIntoSingleValue()
    {
        $list = Collection::from(range(1, 4))
            ->fold(function ($acc, $val) {
                return $acc + $val;
            }, 1);

        $this->assertInternalType('integer', $list);
        $this->assertEquals(11, $list);
    }

    public function testFoldFunctionTransformsListIntoSingleValue()
    {
        $list = Collection::from(range(1, 4))
            ->fold(function ($acc, $val) {
                return $acc + $val;
            }, 1);

        $this->assertEquals(11, $list);
    }

    public function testMergeFunctionCreatesNewCollectionInstance()
    {
        $combined = Collection::from(range(1, 2))
            ->merge(Collection::from(range(3, 4)));

        $this->assertInstanceOf(Collection::class, $combined);
    }

    public function testMergeFunctionCombinesLists()
    {
        $combined = Collection::from(range(1, 2))
            ->merge(Collection::from(range(3, 4)))
            ->getList();

        $this->assertEquals(\SplFixedArray::fromArray([1, 2, 3, 4]), $combined);
    }

    public function testSliceFunctionCreatesNewCollectionInstance()
    {
        $sliced = Collection::from(['foo', 'bar', 'baz'])
            ->slice(2);

        $this->assertInstanceOf(Collection::class, $sliced);
    }

    public function testSliceFunctionRemovesSpecifiedNumberOfElementsFromEndOfList()
    {
        $sliced = Collection::from(['foo', 'bar', 'baz'])
            ->slice(2)
            ->getList();

        $this->assertEquals(\SplFixedArray::fromArray(['baz']), $sliced);
    }

    public function testCollectionInstanceIsJsonSerializable()
    {
        $list = Collection::from(['foo', 'bar', 'baz'])
            ->map('strtoupper');

        $this->assertContains('JsonSerializable', class_implements($list));
        $this->assertInternalType('string', json_encode($list));
    }

    public function testCollectionImplementsIteratorAggregate()
    {
        $list = Collection::from(['FOO', 'BAR'])
            ->map('strtolower');

        $this->assertContains('IteratorAggregate', class_implements($list));
    }

    public function testCollectionClassIsIterable()
    {
        $list = Collection::from([13, 15, 16, 18, 14, 20])
            ->filter(function ($val) {
                return $val % 2 == 0;
            });
        $acc = $list->toArray();

        $this->assertInternalType('array', $acc);
        $this->assertEquals([16, 18, 14, 20], $acc);
    }

    public function testCollectionImplementsCountable()
    {
        $list = Collection::from(['foo', 'bar'])
            ->map('strtoupper');

        $this->assertContains('Countable', class_implements($list));
    }

    public function testCollectionIsCountable()
    {
        $list = Collection::from(['foo', 'bar'])
            ->map('strtoupper');

        $this->assertCount(2, $list);
    }

    public function testReverseMethodCreatesNewCollectionInstance()
    {
        $list = Collection::from(range(0, 10))
            ->reverse();

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testReverseMethodCreatesNewCollectionToArray()
    {
        $list = Collection::from(range(0, 10))
            ->reverse()
            ->toArray();

        $this->assertEquals([10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0], $list);
    }

    public function testReverseMethodReversesListOrder()
    {
        $list = Collection::from(range(0, 10))
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
        $list = Collection::from(range(0, 10))
            ->fill('foo', 2, 5);

        $this->assertInstanceOf(Collection::class, $list);
    }

    public function testFillMethodOutputsListWithArbitraryValuesAffixedToDefinedIndexes()
    {
        $list = Collection::from(range(1, 10))
            ->fill('foo', 2, 5)
            ->getList();

        $this->assertEquals(
            \SplFixedArray::fromArray([1, 2, 'foo', 'foo', 'foo', 'foo', 7, 8, 9, 10]),
            $list
        );
    }

    public function fetchKeyProvider()
    {
        return [
            [
                [
                    ['id' => 35, 'name' => 'Durant'],
                    ['id' => 6, 'name' => 'LeBron']
                ],
                'name',
                ['Durant', 'LeBron']
            ],
            [
                [
                    ['show' => 'Game of Thrones', 'network' => 'HBO'],
                    ['show' => 'The Umbrella Academy', 'network' => 'Netflix']
                ],
                'show',
                ['Game of Thrones', 'The Umbrella Academy']
            ]
        ];
    }

    /**
     * @dataProvider fetchKeyProvider
     */
    public function testFetchOutputsCollectionOfDataGroupedByKey($expected, $key, $result)
    {
        $collection = Collection::from($expected)
            ->fetch($key);

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertEquals($result, $collection->toArray());
    }

    public function containsCheckProvider()
    {
        return [
            [
                [
                    ['id' => 3, 'name' => 'Wade'],
                    ['id' => 24, 'name' => 'Kobe']
                ],
                'Wade',
                true
            ],
            [
                [
                    ['id' => 32, 'name' => 'Shaq'],
                    ['id' => 24, 'name' => 'Kobe']
                ],
                'Wade',
                false
            ]
        ];
    }

    /**
     * @dataProvider containsCheckProvider
     */
    public function testContainsChecksWhetherAValueExistsInACollection($list, $check, $result)
    {
        $check = Collection::from($list)->contains($check);

        $this->assertInternalType('boolean', $check);
        $this->assertEquals($result, $check);
    }

    public function uniqueProvider()
    {
        return [
            [
                range(1, 10),
                range(8, 12),
                range(1, 12)
            ],
            [
                range(1, 5),
                range(5, 6),
                range(1, 6)
            ]
        ];
    }

    /**
     * @dataProvider uniqueProvider
     */
    public function testUniqueFunctionOutputsCollectionWithoutDuplicates($base, $ext, $result)
    {
        $list = Collection::from($base)
            ->merge(Collection::from($ext))
            ->unique();

        $this->assertInstanceOf(Collection::class, $list);
        $this->assertEquals($result, $list->toArray());
    }

    public function testHeadOutputsFirstElementInCollection()
    {
        $first = Collection::from(range(1, 20))->head();

        $this->assertInternalType('integer', $first);
        $this->assertEquals(1, $first);
    }

    public function testTailOutputsCollectionContainingAllListValuesExceptTheFirst()
    {
        $tail = Collection::from(range(4, 9))->tail();

        $this->assertInstanceOf(Collection::class, $tail);
        $this->assertEquals(range(5, 9), $tail->toArray());
    }

    public function testLastOutputsLastElementInACollection()
    {
        $last = Collection::from(['foo', 'bar', 'foo-bar'])->last();

        $this->assertEquals('foo-bar', $last);
        $this->assertInternalType('string', $last);
    }

    public function implodeProvider()
    {
        return [
            [
                ['foo', 'bar', 'baz'],
                '-',
                'foo-bar-baz'
            ],
            [
                ['mike', 'has', 6, 'rings'],
                ' ',
                'mike has 6 rings'
            ]
        ];
    }

    /**
     * @dataProvider implodeProvider
     */
    public function testImplodeFormsStringValueFromDelimiterConcatenatedList($list, $delimiter, $result)
    {
        $imploded = Collection::from($list)->implode($delimiter);

        $this->assertInternalType('string', $imploded);
        $this->assertEquals($result, $imploded);
    }

    public function intersectsProvider()
    {
        return [
            [
                range(54, 99),
                range(32, 89),
                true
            ],
            [
                range(32, 54),
                range(22, 25),
                false
            ]
        ];
    }

    /**
     * @dataProvider intersectsProvider
     */
    public function testIntersectsChecksIfTwoListsHaveAtLeastAnElementInCommon($list, $ext, $result)
    {
        $intersects = Collection::from($list)->intersects(Collection::from($ext));

        $this->assertInternalType('boolean', $intersects);
        $this->assertEquals($result, $intersects);
    }

    public function testOffsetGetsOutputsValueAtSpecifiedOffset()
    {
        $list = Collection::from(range(1, 5));

        $this->assertInternalType('integer', $list->offsetGet(1));
        $this->assertEquals(3, $list->offsetGet(2));
        $this->expectException(\OutOfRangeException::class);
        $list->offsetGet(7);
    }

    public function mergeMultipleProvider()
    {
        return [
            [
                range(1, 5),
                range(6, 10),
                range(11, 15),
                range(1, 15)
            ]
        ];
    }

    /**
     * @dataProvider mergeMultipleProvider
     */
    public function testMergeNMethodFusesMultipleListsIntoOneAmalgam(
        $fst, 
        $snd, 
        $thd, 
        $res
    )
    {
        $list = Collection::from($fst);
        $merged = $list->mergeN(
            Collection::from($snd),
            Collection::from($thd)
        );

        $this->assertInstanceOf(Collection::class, $merged);
        $this->assertEquals(Collection::from($res)->toArray(), $merged->toArray());
    }
}
