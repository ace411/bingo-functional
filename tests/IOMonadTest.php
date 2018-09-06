<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\IO;
use function Chemem\Bingo\Functional\Algorithms\identity;
use function Chemem\Bingo\Functional\Algorithms\reduce;

class IOMonadTest extends \PHPUnit\Framework\TestCase
{
    public function testIOMonadHandlesIOProperly()
    {
        $txt = IO::of(function () {
            return function ($file) {
                return file_get_contents($file);
            };
        })
            ->ap(IO::of(dirname(__DIR__).'/io.test.txt'))
            ->map('strtoupper')
            ->exec();

        $this->assertInternalType('string', $txt);
        $this->assertEquals('THIS IS AN IO MONAD TEST FILE.', $txt);
    }

    public function testOfStaticMethodReturnsIOInstance()
    {
        $this->assertInstanceOf(IO::class, IO::of(function () {
            return 'foo';
        }));
    }

    public function testApMethodMapsOneClassLambdaOntoAnotherClassLambdaValue()
    {
        $apply = IO::of(function () {
            return function ($val) {
                return strtoupper($val);
            };
        })
            ->ap(IO::of('foo'))
            ->flatMap(\Chemem\Bingo\Functional\Algorithms\identity);

        $this->assertEquals('FOO', $apply);
    }

    public function testMapMethodReturnsInstanceOfIOMonad()
    {
        $io = IO::of(function () {
            return 'FOO';
        })
            ->map('strtolower');

        $this->assertInstanceOf(IO::class, $io);
    }

    public function testMapMethodAppliesFunctionToFunctorValue()
    {
        $apply = IO::of(function () {
            return 'foo';
        })
            ->map('strtoupper')
            ->exec();

        $this->assertEquals('FOO', $apply);
    }

    public function testBindMethodReturnsInstanceOfIOMonad()
    {
        $io = IO::of(function () {
            return 'FOO';
        })
            ->bind('strtolower');

        $this->assertInstanceOf(IO::class, $io);
    }

    public function testBindMethodPerformsMapOperation()
    {
        $io = IO::of(function () {
            return range(1, 5);
        })
            ->bind(function ($ints) {
                return reduce(function ($acc, $val) {
                    return $acc + $val;
                }, $ints, 0);
            })
            ->exec();

        $this->assertEquals(15, $io);
    }

    public function testFlatMapOutputsNonIOInstance()
    {
        $io = IO::of('scooter')
            ->flatMap('strtoupper');

        $this->assertInternalType('string', $io);
        $this->assertEquals('SCOOTER', $io);
    }

    public function testExecComputesInternalFunctorLambdaValue()
    {
        $io = IO::of('scooter')
            ->exec();

        $this->assertEquals('scooter', identity('scooter'));
        $this->assertInternalType('string', $io);
    }
}
