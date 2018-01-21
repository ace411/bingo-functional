<?php

use PHPUnit\Framework\TestCase;
use Chemem\Bingo\Functional\Functors\Monads\{IO, Writer, Reader, State, ListMonad};

class MonadTest extends TestCase
{
    public function testIOMonadHandlesIOProperly()
    {
        $readFromFile = function () : string {
            return file_get_contents(dirname(__DIR__) . '/io.test.txt');
        };

        $io = IO::of($readFromFile)
            ->map('strtoupper')
            ->exec();
        
        $this->assertEquals($io, 'THIS IS AN IO MONAD TEST FILE.');
    }

    public function testWriterMonadLogsEfficiently()
    {
        list($result, $log) = Writer::of(2, 'initialize')
            ->bind(
                function ($val) : int {
                    return $val + 2;
                },
                'add 2 to x val'
            )
            ->run();
        
        $this->assertEquals($result, 4);
        $this->assertEquals($log, 'initialize' . PHP_EOL . 'add 2 to x val');
    }

    public function testReaderMonadLazilyEvaluatesEnvironmentVariable()
    {
        $ask = function ($content) : Reader {
            return Reader::of(
                function ($name) use ($content) {
                    return $content . ($name === 'world' ? '' : '. How are you?');
                }
            );
        };

        $sayHello = function ($name) : string {
            return 'Hello ' . $name;
        };

        $reader = Reader::of($sayHello)
            ->withReader($ask)
            ->run('world');

        $this->assertEquals($reader, 'Hello world');
    }

    public function testStateMonadEfficientlyHandlesState()
    {
        $addTen = function (int $val) : int {
            return $val + 10;
        };

        $multiplyByTen = function (int $val) : int {
            return $val * 10;
        };

        list($default, $state) = State::of(2)
            ->evalState($addTen)
            ->bind($multiplyByTen)
            ->exec();
        
        $this->assertEquals($default, 2);
        $this->assertEquals($state, 120);
    }

    public function testListMonadEnablesCollectionTransformation()
    {
        $multiplyByTwo = function (int $val) : int {
            return $val * 2;
        };

        $transformed = ListMonad::of(1, 2, 3)
            ->bind($multiplyByTwo)
            ->extract();

        $this->assertEquals($transformed, [2, 4, 6, 1, 2, 3]);
    }
}
