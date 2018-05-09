<?php

use PHPUnit\Framework\TestCase;
use Chemem\Bingo\Functional\Algorithms as A;

class AlgorithmTest extends TestCase
{
    public function testIdentityFunctionReturnsValueSupplied()
    {
        $value = A\identity('foo');
        $this->assertEquals($value, 'foo');
    }

    public function testComposeFunctionNestsFunctions()
    {
        $addTen = function (int $a) : int {
            return $a + 10;
        };
        $multiplyTen = function (int $b) : int {
            return $b * 10;
        };
        $composed = A\compose($addTen, $multiplyTen);
        $transformed = array_map($composed, [1, 2, 3]);

        $this->assertEquals($transformed, [110, 120, 130]);
    }

    public function testPickGetsArrayIndexValue()
    {
        $toPick = ['bar', 'foo'];

        $picked = A\pick($toPick, 'foo');
        $this->assertEquals($picked, 'foo');
    }

    public function testPluckReturnsArrayValue()
    {
        $toPluck = ['foo' => 'bar', 'baz' => 'foo-bar'];

        $plucked = A\pluck($toPluck, 'foo');
        $this->assertEquals($plucked, 'bar');
    }

    public function testZipReturnsZippedArray()
    {
        $nums = [1, 2];
        $positions = ['PG', 'SG'];

        $zipped = A\zip(
            function ($num, $pos) {
                return $num . ' is ' . $pos;
            },
            $nums,
            $positions
        );
        $this->assertEquals($zipped, ['1 is PG', '2 is SG']);
    }

    public function testCurryReturnsClosure()
    {
        $curryied = A\curry('preg_match');

        $this->assertInstanceOf(\Closure::class, $curryied);
    }

    public function testCurryNReturnsCurryiedFunction()
    {
        $curryied = A\curryN(2, 'array_key_exists')('foo')(['foo' => 'bar']);

        $this->assertEquals($curryied, true);
    }

    public function testUnzipReturnsArrayOfInitiallyGroupedArrays()
    {
        $zipped = A\zip(null, [1, 2], ['PG', 'SG']);
        $unzipped = A\unzip($zipped);

        $this->assertEquals(
            $unzipped,
            [
                [1, 2],
                ['PG', 'SG']
            ]
        );
        $this->assertTrue(is_array($unzipped));
    }

    public function testPartialLeftAppliesArgumentsFromLeftToRight()
    {
        $fn = function (int $a, int $b) : int {
            return $a + $b;
        };
        $partial = A\partialLeft($fn, 2)(2);

        $this->assertEquals($partial, 4);
    }

    public function testHeadReturnsFirstItemInArray()
    {
        $array = [1, 2, 3, 4];
        $this->assertEquals(A\head($array), 1);
    }

    public function testTailReturnsSecondToLastArrayItems()
    {
        $array = [1, 2, 3, 4];
        $this->assertEquals(
            A\tail($array),
            [2, 3, 4]
        );
    }

    public function testPartitionSubDividesArray()
    {
        $array = [1, 2, 3, 4];
        $this->assertEquals(
            A\partition(2, $array),
            [[1, 2], [3, 4]]
        );
    }

    public function testExtendAppendsElementsOntoArray()
    {
        $array = ['foo' => 'bar', 'baz' => 12];
        $extended = A\extend($array, ['foo' => 9, 'bar' => 19]);
        $this->assertEquals(
            $extended,
            [
                'foo' => 9,
                'baz' => 12,
                'bar' => 19
            ]
        );
    }

    public function testConstantFunctionAlwaysReturnsFirstArgumentSupplied()
    {
        $const = A\constantFunction(12);
        $this->assertEquals($const(), 12);
    }

    public function testIsArrayOfReturnsArrayType()
    {
        $array = [1, 2, 3, 4];
        $type = A\isArrayOf($array);

        $this->assertEquals($type, 'integer');
    }

    public function testPartialRightReversesParameterOrder()
    {
        $divide = function (int $a, int $b) {
            return $a / $b;
        };

        $partialRight = A\partialRight($divide, 6)(3);
        $this->assertEquals($partialRight, 0.5);
    }

    public function testThrottleFunctionReturnsSuppliedFunctionReturnValue()
    {
        $action = function (int $val) {
            return $val + 10;
        };

        $throttle = A\throttle($action, 5);

        $this->assertEquals($throttle(2), 12);
    }

    public function testConcatFunctionConcatenatesStrings()
    {
        $wildcard = '/';
        $testsPath = A\concat($wildcard, 'path', 'to', 'tests');

        $this->assertEquals($testsPath, 'path/to/tests');
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

        $this->assertEquals($transformed, [11, 12, 13, 14, 15]);
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

        $this->assertEquals($filtered, [1, 2, 3]);
    }

    public function testFoldFunctionTransformsCollectionIntoSingleValue()
    {
        $characters = [
            ['name' => 'Tyrion', 'incest' => false],
            ['name' => 'Cersei', 'incest' => true],
            ['name' => 'Jaimie', 'incest' => true]
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

        $this->assertEquals($reduce, 2);
    }

    public function testArrayKeysExistFunctionDeterminesIfKeysExistInCollection()
    {
        $character = [
            'name' => 'Tyrion',
            'house' => 'Lannister'
        ];

        $testBasicInfoIsSet = A\arrayKeysExist($character, 'name', 'house');

        $this->assertEquals($testBasicInfoIsSet, true);
    }

    public function testDropLeftFunctionRemovesArrayItemsFromTheFirstIndexOnwards()
    {
        $numbers = [1, 2, 3, 4, 5];

        $modified = A\dropLeft($numbers, 2);

        $this->assertEquals($modified, [3, 4, 5]);
    }

    public function testDropRightFunctionRemovesArrayItemsFromTheLastIndexBackwards()
    {
        $numbers = [1, 2, 3, 4, 5];

        $modified = A\dropRight($numbers, 2);

        $this->assertEquals($modified, [1, 2, 3]);
    }

    public function testUniqueFunctionRemovesDuplicateValuesInCollection()
    {
        $values = ['foo', 'bar', 'baz', 'foo'];

        $unique = A\unique($values);

        $this->assertEquals($unique, ['foo', 'bar', 'baz']);
    }

    public function testFlattenFunctionLowersArrayDimensionsByOneLevel()
    {
        $collection = [['foo', 'bar'], 1, 2, 3];

        $flattened = A\flatten($collection);

        $this->assertEquals($flattened, ['foo', 'bar', 1, 2, 3]);
    }

    public function testCompactFunctionPurgesCollectionOfFalseyValues()
    {
        $mixed = [1, 2, 'foo', false, null];

        $purged = A\compact($mixed);

        $this->assertEquals($purged, [1, 2, 'foo']);
    }

    public function testFillFunctionFillsArrayIndexesWithArbitraryValues()
    {
        $fill = A\fill([1, 2, 3, 4, 5, 6, 7], 'foo', 1, 4);

        $this->assertEquals($fill, [1, 'foo', 'foo', 'foo', 'foo', 6, 7]);
    }

    public function testIndexOfFunctionComputesArrayValueIndex()
    {
        $index = A\indexOf([1, 2, 3, 4], 2);

        $this->assertEquals($index, 1);
    }

    public function testReverseFunctionComputesReverseOfArray()
    {
        $reverse = A\reverse(['foo', 'bar', 'baz']);

        $this->assertEquals($reverse, ['baz', 'bar', 'foo']);
    }

    public function testFromPairsFunctionCreatesKeyValueArrayPairs()
    {
        $fromPairs = A\fromPairs([
            ['foo', 'baz'], 
            ['bar', 'baz'], 
            ['boo', 1]
        ]);

        $this->assertEquals($fromPairs, [
            'foo' => 'baz',
            'bar' => 'baz',
            'boo' => 1
        ]);
    }

    public function testToPairsFunctionCreatesArraysWithTwoElementsEach()
    {
        $toPairs = A\toPairs([
            'foo' => 'baz', 
            'bar' => 'baz', 
            'boo' => 1
        ]);

        $this->assertEquals($toPairs, [
            ['foo', 'baz'], 
            ['bar', 'baz'], 
            ['boo', 1]
        ]);
    }

    public function testMemoizeFunctionComputesMemoizedFunction()
    {
        $factorial = function (int $num) use (&$factorial) {
            return $num < 2 ? 1 : $num * $factorial($num - 1);
        };

        $memoize = A\memoize($factorial(5));

        $this->assertEquals($memoize, 120);
    }
}
