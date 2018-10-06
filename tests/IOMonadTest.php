<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\IO;
use function Chemem\Bingo\Functional\Algorithms\concat;
use function Chemem\Bingo\Functional\Algorithms\identity;
use function Chemem\Bingo\Functional\Algorithms\reduce;
use function Chemem\Bingo\Functional\Functors\Monads\IO\IO;
use function Chemem\Bingo\Functional\Functors\Monads\IO\putChar;
use function Chemem\Bingo\Functional\Functors\Monads\IO\putStr;
use function Chemem\Bingo\Functional\Functors\Monads\IO\readFile;
use function Chemem\Bingo\Functional\Functors\Monads\IO\readIO;

class IOMonadTest extends \PHPUnit\Framework\TestCase
{
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
            ->bind(function (string $txt) {
                return IO::of(strtoupper($txt));
            });

        $this->assertInstanceOf(IO::class, $io);
    }

    public function testBindMethodPerformsMapOperation()
    {
        $io = IO::of(function () {
            return range(1, 5);
        })
            ->bind(function ($ints) {
                return IO::of(reduce(function ($acc, $val) {
                    return $acc + $val;
                }, $ints, 0));
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

    public function testPutCharFunctionOutputsFunctionWrappedInsideIO()
    {
        $this->assertInstanceOf(IO::class, putChar());
        $this->assertInstanceOf(\Closure::class, putChar()->exec());
    }

    public function testPutStrFunctionOutputsFunctionWrappedInsideIO()
    {
        $this->assertInstanceOf(IO::class, putStr());
        $this->assertInstanceOf(\Closure::class, putStr()->exec());
    }

    public function testReadIOMethodReadsStringInput()
    {
        $read = readIO(IO('foo'));

        $this->assertInstanceOf(IO::class, $read);
        $this->assertInternalType('string', $read->exec());
    }

    public function testReadFileOutputsFileContents()
    {
        $file = readfile(concat('/', dirname(__DIR__), 'io.test.txt'));

        $this->assertInstanceOf(IO::class, $file);
        $this->assertInternalType('string', $file->exec());
        $this->assertEquals('THIS IS AN IO MONAD TEST FILE.', $file->flatMap('strtoupper'));
    }
}
