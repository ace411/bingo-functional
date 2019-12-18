<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Algorithms as A;
use PHPUnit\Framework\TestCase;

class AlgorithmTest extends TestCase
{
    public function testIdentityFunctionReturnsValueSupplied()
    {
        $value = A\identity('foo');
        $this->assertEquals('foo', $value);
    }

    public function testComposeFunctionNestsFunctions()
    {
        $addTen = function (int $a): int {
            return $a + 10;
        };
        $multiplyTen = function (int $b): int {
            return $b * 10;
        };
        $composed = A\compose($addTen, $multiplyTen);
        $transformed = array_map($composed, [1, 2, 3]);

        $this->assertEquals([110, 120, 130], $transformed);
    }

    public function testComposeRightFunctionChainsFunctionsFromRightToLeft()
    {
        $compose = A\composeRight('lcfirst', 'strtoupper');

        $this->assertInstanceOf(\Closure::class, $compose);
        $this->assertEquals('mIKE', $compose('mike'));
    }

    public function testPickGetsSpecifiedArrayIndexValue()
    {
        $toPick = ['bar', 'foo'];

        $pick   = A\partial(A\pick, $toPick);
        $this->assertEquals('foo', $pick('foo'));
        $this->assertEquals(null, $pick('baz'));
    }

    public function testPluckEvaluatesToSpecifiedObjectPropertyValue()
    {
        $toPick = (object)[
            'foo' => 'bar',
            'bar' => 'baz'
        ];

        $pick   = A\partial(A\pick, $toPick);

        $this->assertEquals('baz', $pick('baz'));
        $this->assertEquals(null, $pick('foo'));
    }

    public function testPluckReturnsSpecifiedArrayValue()
    {
        $toPluck    = ['foo' => 'bar', 'baz' => 'foo-bar'];

        $pluck      = A\partial(A\pluck, $toPluck);
        $this->assertEquals('bar', $pluck('foo'));
        $this->assertEquals(null, $pluck('bar'));
    }

    public function testPluckEvaluatesToSpecifiedObjectProperty()
    {
        $toPluck    = (object)[
            'foo' => 'bar',
            'baz' => 'foo-bar'
        ];

        $pluck      = A\partial(A\pluck, $toPluck);
        $this->assertEquals('bar', $pluck('foo'));
        $this->assertEquals(null, $pluck('bar'));
    }

    public function testZipReturnsZippedArray()
    {
        $nums = [1, 2];
        $positions = ['PG', 'SG'];

        $zipped = A\zip($nums, $positions);

        $this->assertEquals([[1, 'PG'], [2, 'SG']], $zipped);
    }

    public function testCurryReturnsClosure()
    {
        $curryied = A\curry('preg_match');

        $this->assertInstanceOf(\Closure::class, $curryied);
    }

    public function testCurryRightReturnsClosure()
    {
        $curryied = A\curryRight('preg_match');

        $this->assertInstanceOf(\Closure::class, $curryied);
    }

    public function testCurryNReturnsCurryiedFunction()
    {
        $curryied = A\curryN(2, 'array_key_exists')('foo')(['foo' => 'bar']);

        $this->assertTrue($curryied);
    }

    public function testCurryRightNReturnsCurryiedFunction()
    {
        $curryied = A\curryRightN(2, 'array_key_exists')(['foo' => 'bar'])('baz');

        $this->assertFalse($curryied);
    }

    public function testUnzipReturnsArrayOfInitiallyGroupedArrays()
    {
        $zipped = A\zip(range(1, 2), ['PG', 'SG']);
        $unzipped = A\unzip($zipped);

        $this->assertEquals(
            $unzipped,
            [
                [1, 2],
                ['PG', 'SG'],
            ]
        );
        $this->assertInternalType('array', $unzipped);
    }

    public function testPartialLeftAppliesArgumentsFromLeftToRight()
    {
        $fn = function (int $a, int $b): int {
            return $a + $b;
        };
        $partial = A\partialLeft($fn, 2)(2);

        $this->assertEquals(4, $partial);
    }

    public function testHeadReturnsFirstItemInArray()
    {
        $array = [1, 2, 3, 4];
        $this->assertEquals(1, A\head($array));
    }

    public function testTailReturnsSecondToLastArrayItems()
    {
        $array = [1, 2, 3, 4];
        $this->assertEquals(
            [2, 3, 4],
            A\tail($array)
        );
    }

    public function testPartitionSubDividesArray()
    {
        $array = [1, 2, 3, 4];
        $this->assertEquals(
            [[1, 2], [3, 4]],
            A\partition(2, $array)
        );
    }

    public function testPartitionBySubDividesArray()
    {
        $list = A\partitionBy(5, range(1, 20));
        
        $this->assertEquals(
            [
                [1, 2, 3, 4, 5],
                [6, 7, 8, 9, 10],
                [11, 12, 13, 14, 15],
                [16, 17, 18, 19, 20]
            ],
            $list
        );
        $this->assertTrue(count($list) == 4);
    }

    public function testConstantFunctionAlwaysReturnsFirstArgumentSupplied()
    {
        $const = A\constantFunction(12);
        $this->assertEquals(12, $const());
    }

    public function testIsArrayOfReturnsArrayType()
    {
        $array = [1, 2, 3, 4];
        $type = A\isArrayOf($array);

        $this->assertEquals('integer', $type);
    }

    public function testPartialRightReversesParameterOrder()
    {
        $divide = function (int $a, int $b) {
            return $a / $b;
        };

        $partialRight = A\partialRight($divide, 6)(3);
        $this->assertEquals(0.5, $partialRight);
    }

    public function testThrottleFunctionReturnsSuppliedFunctionReturnValue()
    {
        $action = function (int $val) {
            return $val + 10;
        };

        $throttle = A\throttle($action, 5);

        $this->assertEquals(12, $throttle(2));
    }

    public function testConcatFunctionConcatenatesStrings()
    {
        $wildcard = '/';
        $testsPath = A\concat($wildcard, 'path', 'to', 'tests');

        $this->assertEquals('path/to/tests', $testsPath);
    }

    public function mapFunctionTransformsArrayElements()
    {
        $numbers = [1, 2, 3, 4, 5];

        $transformed = A\map(
            function ($val) {
                return $val + 10;
            },
            $numbers
        );

        $this->assertEquals([11, 12, 13, 14, 15], $transformed);
    }

    public function testFilterFunctionSelectsArrayElementsBasedOnBooleanPredicate()
    {
        $numbers = [1, 2, 3, 4, 5];

        $filtered = A\filter(
            function ($val) {
                return $val < 4;
            },
            $numbers
        );

        $this->assertEquals([1, 2, 3], $filtered);
    }

    public function testFoldFunctionTransformsCollectionIntoSingleValue()
    {
        $characters = [
            ['name' => 'Tyrion', 'incest' => false],
            ['name' => 'Cersei', 'incest' => true],
            ['name' => 'Jaimie', 'incest' => true],
        ];

        $reduce = A\fold(
            function ($acc, $val) {
                return $val['incest'] === true ?
                    $acc + 1 :
                    $acc;
            },
            $characters,
            0
        );

        $this->assertEquals(2, $reduce);
    }

    public function testFoldRightFunctionReducesArrayFromRightToLeft()
    {
        $strings = ['foo', 'bar', 'baz'];

        $foldFn = function ($acc, $val) {
            return $acc . '-' . $val;
        };

        $fold = A\foldRight($foldFn, $strings, 'fum');

        $this->assertEquals('fum-baz-bar-foo', $fold);
    }

    public function testArrayKeysExistFunctionDeterminesIfKeysExistInCollection()
    {
        $character = [
            'name'  => 'Tyrion',
            'house' => 'Lannister',
        ];

        $testBasicInfoIsSet = A\arrayKeysExist($character, 'name', 'house');

        $this->assertTrue($testBasicInfoIsSet);
    }

    public function testDropLeftFunctionRemovesArrayItemsFromTheFirstIndexOnwards()
    {
        $numbers = [1, 2, 3, 4, 5];

        $modified = A\dropLeft($numbers, 2);

        $this->assertEquals([2 => 3, 3 => 4, 4 => 5], $modified);
    }

    public function testDropRightFunctionRemovesArrayItemsFromTheLastIndexBackwards()
    {
        $numbers = [1, 2, 3, 4, 5];

        $modified = A\dropRight($numbers, 2);

        $this->assertEquals([1, 2, 3], $modified);
    }

    public function testUniqueFunctionRemovesDuplicateValuesInCollection()
    {
        $values = ['foo', 'bar', 'baz', 'foo'];

        $unique = A\unique($values);

        $this->assertEquals(['foo', 'bar', 'baz'], $unique);
    }

    public function testFlattenFunctionLowersArrayDimensionsByOneLevel()
    {
        $collection = [['foo', 'bar'], 1, 2, 3];

        $flattened = A\flatten($collection);

        $this->assertEquals(['foo', 'bar', 1, 2, 3], $flattened);
    }

    public function testCompactFunctionPurgesCollectionOfFalseyValues()
    {
        $mixed = [1, 2, 'foo', false, null];

        $purged = A\compact($mixed);

        $this->assertEquals([1, 2, 'foo'], $purged);
    }

    public function testFillFunctionFillsArrayIndexesWithArbitraryValues()
    {
        $fill = A\fill([1, 2, 3, 4, 5, 6, 7], 'foo', 1, 4);

        $this->assertEquals([1, 'foo', 'foo', 'foo', 'foo', 6, 7], $fill);
    }

    public function testIndexOfFunctionComputesArrayValueIndex()
    {
        $index = A\indexOf([1, 2, 3, 4], 2);

        $this->assertEquals(1, $index);
    }

    public function testFromPairsFunctionCreatesKeyValueArrayPairs()
    {
        $fromPairs = A\fromPairs([
            ['foo', 'baz'],
            ['bar', 'baz'],
            ['boo', 1],
        ]);

        $this->assertEquals([
            'foo' => 'baz',
            'bar' => 'baz',
            'boo' => 1,
        ], $fromPairs);
    }

    public function testToPairsFunctionCreatesArraysWithTwoElementsEach()
    {
        $toPairs = A\toPairs([
            'foo' => 'baz',
            'bar' => 'baz',
            'boo' => 1,
        ]);

        $this->assertEquals([
            ['foo', 'baz'],
            ['bar', 'baz'],
            ['boo', 1],
        ], $toPairs);
    }

    public function testMemoizeFunctionComputesMemoizedFunction()
    {
        $factorial = A\memoize(
            function (int $num) use (&$factorial) {
                return $num < 2 ? 1 : $num * $factorial($num - 1);
            }
        );

        $this->assertEquals(120, $factorial(5));
    }

    public function testEveryFunctionEvaluatesBooleanPredicate()
    {
        $every = A\every(
            [1, 2, 3, false, true],
            function ($val) {
                return is_bool($val);
            }
        );

        $this->assertFalse($every);
    }

    public function testAnyFunctionFindsFirstOccurenceOfFunctionComplianceInList()
    {
        $any = A\any(
            [1, 2, 3, false, true],
            function ($val) {
                return is_bool($val);
            }
        );

        $this->assertTrue($any);
    }

    public function testGroupByFunctionCreatesArrayGroupedByKey()
    {
        $grouped = A\groupBy(
            [
                ['name' => 'goran', 'pos' => 'pg'],
                ['name' => 'josh', 'pos' => 'sg'],
                ['name' => 'dwayne', 'pos' => 'sg'],
            ],
            'pos'
        );

        $this->assertEquals(
            [
                'sg' => [
                    ['name' => 'josh', 'pos' => 'sg'],
                    ['name' => 'dwayne', 'pos' => 'sg'],
                ],
                'pg' => [
                    ['name' => 'goran', 'pos' => 'pg'],
                ],
            ],
            $grouped
        );
    }

    public function testWhereFunctionSearchesArrayForKeyValuePair()
    {
        $find = A\where(
            [
                ['name' => 'dwayne', 'pos' => 'sg'],
                ['name' => 'james', 'pos' => 'sf'],
                ['name' => 'demarcus', 'pos' => 'c'],
            ],
            ['pos' => 'c']
        );

        $this->assertEquals(
            [
                ['name' => 'demarcus', 'pos' => 'c'],
            ],
            $find
        );
    }

    public function testMinFunctionComputesLowestValueInList()
    {
        $min = A\min([23, 45, 12, 78]);

        $this->assertEquals(12, (int) $min);
        $this->assertInternalType('float', $min);
    }

    public function testMaxFunctionComputesLargestValueInList()
    {
        $max = A\max([23, 79, 54, 24]);

        $this->assertEquals(79, (int) $max);
        $this->assertInternalType('float', $max);
    }

    public function testToExceptionWrapsFunctionPrintsExceptionMessageIfExceptionIsThrownOrResult()
    {
        $func = function () {
            throw new \Exception('I am an exception');
        };

        $result = function ($val) {
            return $val * 2;
        };

        $this->assertEquals('I am an exception', A\toException($func)());
        $this->assertInstanceOf(\Closure::class, A\toException($func));
        $this->assertEquals(24, A\toException($result)(12));
    }

    public function testToExceptionAllowsForOptionalArbitraryExceptionHandlingViaHandler()
    {
        $func = function (int $val) {
            if ($val < 5) {
                throw new \Exception(A\concat(' ', (string) $val, 'is too low'));
            }

            return $val + 2;
        };
        $expHandler = A\toException($func, function (\Exception $exp) {
            return strtoupper($exp->getMessage());
        });

        $this->assertEquals('2 IS TOO LOW', $expHandler(2));
    }

    public function testTrampolineIsCurriedByDefault()
    {
        $fib = A\trampoline(
            function ($val) use (&$fib) {
                return $val < 2 ? $val : $fib($val - 1) + $fib($val - 2);
            }
        );

        $this->assertInstanceOf(\Closure::class, $fib);
    }

    public function testTrampolineEvaluatesRecursiveFunction()
    {
        $fib = A\trampoline(
            function ($val) use (&$fib) {
                return $val < 2 ? $val : $fib($val - 1) + $fib($val - 2);
            }
        );

        $this->assertEquals(89, $fib(11));
    }

    public function testMeanFunctionComputesTheAverageOfNumbersInAList()
    {
        $mean = A\mean([12, 13, 14, 19]);

        $this->assertEquals(14.5, $mean);
        $this->assertInternalType('float', $mean);
    }

    public function testRejectFunctionReturnsArrayWhoseValuesDoNotConformToBooleanPredicate()
    {
        $list = A\reject(function ($val) {
            return strlen($val) > 4;
        }, ['foo', 'bar', 'foobar']);

        $this->assertEquals(['foo', 'bar'], $list);
        $this->assertInternalType('array', $list);
    }

    public function testLastFunctionOutputsTheLastValueInAnArray()
    {
        $this->assertEquals('foo', A\last(['bar', 'baz', 'foo']));
    }

    public function testMapDeepFunctionAppliesFunctionToAllValuesInMultiDimensionalArray()
    {
        $deep = A\mapDeep(function ($val) {
            return $val * 2;
        }, [1, 2, [3, 4], [5, [6, 7]]]);

        $this->assertEquals([2, 4, [6, 8], [10, [12, 14]]], $deep);
    }

    public function testFilterDeepFunctionEvaluatesEachValueMultidimensionalArrayBasedOnBooleanPredicate()
    {
        $filter = A\filterDeep(function ($val) {
            return $val > 5;
        }, [1, 2, [3, 4], [5, [6, 7, 99]]]);

        $this->assertEquals([6, 7, 99], $filter);
        $this->assertInternalType('array', $filter);
    }

    public function testOmitFunctionOutputsArrayWithoutSpecifiedKeys()
    {
        $omit = A\omit(['foo' => 12, 'bar' => 13, 'baz' => 13], 'foo', 'baz');

        $this->assertInternalType('array', $omit);
        $this->assertEquals(['bar' => 13], $omit);
    }

    public function testAddKeysOutputsArrayWithSpecifiedKeys()
    {
        $add = A\addKeys(['foo' => 12, 'bar' => 13, 'baz' => 15], 'foo', 'baz');

        $this->assertInternalType('array', $add);
        $this->assertEquals(['foo' => 12, 'baz' => 15], $add);
    }

    public function testFlipFunctionReversesFunctionArgumentOrder()
    {
        $flip = A\flip(function ($valX, $valY) {
            return ($valX / $valY) * 3;
        });

        $this->assertEquals(15, $flip(2, 10));
    }

    public function testUnionFunctionCombinesArrays()
    {
        $union = A\union(range(1, 3), [2, 4, 9, 11]);

        $this->assertInternalType('array', $union);
        $this->assertEquals([1, 2, 3, 4, 9, 11], array_values($union));
    }

    public function testUnionWithFunctionCombinesArraysUponFulfillmentOfCondition()
    {
        $union = A\unionWith(function (array $num, array $str) {
            return A\isArrayOf($num) == 'integer' && A\isArrayOf($str) == 'string';
        }, range(1, 3), range(4, 9));

        $this->assertInternalType('array', $union);
        $this->assertEquals([], $union);
    }

    public function testZipWithFunctionZipsListsBasedOnFunctionPredicate()
    {
        $zipped = A\zipWith(function (int $int, string $str): int {
            return $int + strlen($str);
        }, range(1, 3), ['foo', 'bar', 'baz']);

        $this->assertInternalType('array', $zipped);
        $this->assertEquals([4, 5, 6], $zipped);
    }

    public function testFilePathFunctionOutputsStringSeparatedBySlashes()
    {
        $path = A\filePath(1, 'composer.json');

        $this->assertInternalType('string', $path);
        $this->assertRegExp('/([\/\\\])+/', $path);
    }

    public function testToWordsFunctionTransformsStringIntoArrayOfWords()
    {
        $words = A\toWords('lorem ipsum dolor sit & amet', '/[\s\&]+/');

        $this->assertInternalType('array', $words);
        $this->assertEquals(['lorem', 'ipsum', 'dolor', 'sit', 'amet'], $words);
    }

    public function testTruncateFunctionShortensStringAndAppendsEllipsisToIt()
    {
        $truncated = A\truncate('lorem ipsum dolor sit amet', 5);

        $this->assertInternalType('string', $truncated);
        $this->assertEquals('lorem...', $truncated);
    }

    public function testSlugifyReplacesSpacesWithDashesInText()
    {
        $slugified = A\slugify('lorem ipsum dolor');

        $this->assertInternalType('string', $slugified);
        $this->assertEquals('lorem-ipsum-dolor', $slugified);
    }

    public function testIntersectsFunctionDeterminesIfTwoArraysHaveAtLeastACommonItem()
    {
        $intersect = A\partial(A\intersects, range(1, 15));

        $this->assertTrue($intersect(range(12, 19)));
        $this->assertFalse($intersect(range(19, 22)));
        $this->assertInternalType('boolean', $intersect(range(2, 4)));
    }

    public function testCountOfValueOutputsArrayValueCount()
    {
        $count = A\countOfValue([1, 2, 3, [4, 3]], 3);

        $this->assertInternalType('integer', $count);
        $this->assertEquals(2, $count);
    }

    public function testCountOfKeyOutputsArrayKeyValueCount()
    {
        $count = A\countOfKey([
            [
                'player' => 'Wade',
                'number' => 3
            ],
            [
                'player' => 'Jordan',
                'number' => 23
            ]
        ], 'number');

        $this->assertInternalType('integer', $count);
        $this->assertEquals(2, $count);
    }

    public function testDifferenceOutputsDifferenceOfMultipleArrays()
    {
        $diff = A\difference(range(1, 5), [99, 3], range(4, 5));

        $this->assertInternalType('array', $diff);
        $this->assertEquals([1, 2, 99], $diff);
    }

    public function testRenameKeysFunctionOutputsArrayWithDifferentNameKeys()
    {
        $lists = [
            [0 => 'ace411', 'twitter' => '@agiroLoki'],
            [0 => 'github'],
            ['twitter' => 1]
        ];
        $func = A\partial(A\renameKeys, $lists[0]);
        
        $this->assertInternalType('array', $func($lists[1]));
        $this->assertEquals([
            'github' => 'ace411',
            'twitter' => '@agiroLoki'
        ], $func($lists[1]));
        $this->assertInternalType('array', $func($lists[2]));
        $this->assertEquals([
            0 => 'ace411',
            1 => '@agiroLoki'
        ], $func($lists[2]));
    }

    public function testContainsChecksIfNeedleExistsInHaystack()
    {
        $check = A\partial(A\contains, 'haystack');

        $this->assertInternalType('boolean', $check('hay'));
        $this->assertEquals(true, $check('hay'));
        $this->assertEquals(false, $check('buck'));
    }

    public function testStartsWithChecksIfHaystackStartsWithNeedle()
    {
        $check = A\partial(A\startsWith, 'haystack');

        $this->assertInternalType('boolean', $check('hay'));
        $this->assertEquals(true, $check('hay'));
        $this->assertEquals(false, $check('stack'));
    }

    public function testEndsWithChecksIfHaystackEndsWithNeedle()
    {
        $check = A\partial(A\endsWith, 'haystack');

        $this->assertInternalType('boolean', $check('hay'));
        $this->assertEquals(false, $check('hay'));
        $this->assertEquals(true, $check('stack'));
    }

    public function testIndexesOfOutputsIndexesOfValuesInHashTable()
    {
        $indexes = A\partial(A\indexesOf, [
            'foo'   => 1,
            'bar'   => 2,
            'baz'   => [2, 3]
        ]);

        $this->assertEquals(['bar', 0], $indexes(2));
        $this->assertEquals([], $indexes('foo'));
    }

    public function testFirstIndexOfOutputsFirstComputedIndexOfArrayValue()
    {
        $first = A\partial(A\firstIndexOf, [
            'foo'   => 1,
            'bar'   => 2,
            'baz'   => [2, 3]
        ]);

        $this->assertEquals('foo', $first(1));
        $this->assertEquals(false, $first('foo'));
    }

    public function testLastIndexOfOutputsLastComputedIndexOfArrayValue()
    {
        $last = A\partial(A\lastIndexOf, [
            'foo'   => 1,
            'bar'   => 2,
            'baz'   => [2, 3]
        ]);

        $this->assertEquals(0, $last(2));
        $this->assertEquals(false, $last('foo'));
    }

    public function testIntersperseFunctionInterspersesElementBetweenListItems()
    {
        $list           = [
            ['foo', 'bar', 'baz'],
            range(1, 3)
        ];

        $intersperse    = A\partial(A\intersperse, ',');

        $this->assertInternalType('array', $intersperse(A\head($list)));
        $this->assertInternalType('array', $intersperse(A\last($list)));
        $this->assertEquals(['foo', ',', 'bar', ',', 'baz'], $intersperse(A\head($list)));
        $this->assertEquals([1, ',', 2, ',', 3], $intersperse(A\last($list)));
    }
}
