<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\Writer;

class WriterMonadTest extends \PHPUnit\Framework\TestCase
{
    public function testOfStaticMethodOutputsInstanceOfWriterMonad()
    {
        $this->assertInstanceOf(Writer::class, Writer::of(12, 'Received 12'));
    }

    public function testApMethodOutputsWriterMonadInstance()
    {
        $val = Writer::of(function ($val) {
            return $val * 2;
        }, 'Received lambda')
            ->ap(Writer::of(12, 'Received 12'), 'Applied lambda to 12');

        $this->assertInstanceOf(Writer::class, $val);
    }

    public function testApMethodOutputsWriterWithAllLoggedStateChanges()
    {
        list($orig, $msg) = Writer::of(function ($val) {
            return $val * 2;
        }, 'Received lambda')
            ->ap(Writer::of(12, 'Received 12'), 'Applied lambda to 12')
            ->run();

        list($val, $mid) = $orig->run();

        $this->assertInternalType('string', $msg);
        $this->assertInternalType('string', $mid);
        $this->assertEquals(24, $val);
    }

    public function testMapMethodOutputsWriterMonadInstance()
    {
        $val = Writer::of('foo', 'Received foo')->map('strtoupper', 'Converted string to uppercase');

        $this->assertInstanceOf(Writer::class, $val);
    }

    public function testMapMethodAppliesFunctionToFunctorValueAndLogsAction()
    {
        list($val, $msg) = Writer::of('foo', 'Received foo')->map('strtoupper', 'Converted string to uppercase')->run();

        $this->assertEquals('FOO', $val);
        $this->assertInternalType('string', $msg);
    }

    public function testFlatMapMethodOutputsArrayContainingValueAndActionLog()
    {
        $action = Writer::of(39, 'Received 39')
            ->flatMap(function ($val) {
                return $val % 2 == 0 ? $val * 2 : $val + 1;
            }, 'Applied function to value');

        $this->assertInternalType('array', $action);
        $this->assertEquals(40, $action[0]);
        $this->assertInternalType('string', $action[1]);
    }
}
