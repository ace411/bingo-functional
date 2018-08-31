<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\State;
use function Chemem\Bingo\Functional\Algorithms\filter;

class StateMonadTest extends \PHPUnit\Framework\TestCase
{
    public function testOfStaticMethodOutputsStateInstance()
    {
        $this->assertInstanceOf(State::class, State::of(12));
    }

    public function testApMethodOutputsNewAppliedState()
    {
        list($old, $new) = State::of(function ($val) {
            return $val * 2;
        })
            ->ap(State::of(14))
            ->exec();

        $this->assertInstanceOf(State::class, $new);
        $this->assertInstanceOf(\Closure::class, $old);
        $this->assertEquals([14, 28], $new->exec());
    }

    public function testMapMethodOutputsInstanceOfStateMonad()
    {
        $val = State::of('foo')->map('strtoupper');

        $this->assertInstanceOf(State::class, $val);
    }

    public function testMapMethodAppliesFunctionToFunctorValueAndPreservesOldState()
    {
        list($old, $new) = State::of('foo')->map('strtoupper')->exec();

        $this->assertEquals('FOO', $new);
        $this->assertEquals('foo', $old);
    }

    public function testBindMethodOutputsInstanceOfStateMonad()
    {
        $val = State::of('FOO')->bind('strtolower');

        $this->assertInstanceOf(State::class, $val);
    }

    public function testFlatMapMethodAppliesFunctionToFunctorValueAndPreservesOldState()
    {
        $val = State::of(range(1, 10))->flatMap(function ($list) {
            return filter(function ($val) {
                return $val % 2 == 0;
            }, $list);
        });

        $this->assertInternalType('array', $val);
        $this->assertEquals(range(1, 10), $val[0]);
        $this->assertEquals([1 => 2, 3 => 4, 5 => 6, 7 => 8, 9 => 10], $val[1]);
    }

    public function testExecMethodOuputsAnArrayContainingInitialAndNewStates()
    {
        $val = State::of('foo')->map('strtoupper')->exec();

        $this->assertInternalType('array', $val);
        $this->assertEquals('foo', $val[0]);
        $this->assertEquals('FOO', $val[1]);
    }
}
