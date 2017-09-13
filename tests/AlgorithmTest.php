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
        $toPick = ['foo' => 'bar', 'baz' => 12];

        $picked = A\pick($toPick, 'foo');
        $this->assertEquals($picked, 'bar');
    }

    public function testPluckReturnsArrayValue()
    {
        $toPluck = ['foo', 'bar', 'baz'];

        $plucked = A\pluck($toPluck, 'bar');
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

    public function testPartialReturnsAPartiallyAppliedFunction()
    {
        $fn = function (int $a, int $b) : int {
            return $a + $b;
        };
        $partial = A\partial($fn, 1);

        $this->assertInstanceOf(Closure::class, $partial);
        $this->assertEquals($partial(2), 3);
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
}
