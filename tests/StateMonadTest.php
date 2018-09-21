<?php

namespace Chemem\Bingo\Functional\Tests;

use \Chemem\Bingo\Functional\Functors\Monads\State;
use function \Chemem\Bingo\Functional\Algorithms\filter;
use function \Chemem\Bingo\Functional\Functors\Monads\State\{
    state, 
    put, 
    get, 
    gets, 
    modify, 
    runState, 
    evalState, 
    execState
};

class StateMonadTest extends \PHPUnit\Framework\TestCase
{
    public function testOfStaticMethodOutputsStateInstance()
    {
        $this->assertInstanceOf(State::class, State::of(12));
    }

    public function testStateFunctionEmbedsSimpleStateActionInStateMonad()
    {
        $action = state(function ($val) {
            return $val * 2;
        });

        $this->assertInstanceOf(State::class, $action);
        $this->assertInstanceOf(\Closure::class, evalState($action, 11));
    }

    public function testPutFunctionReplacesStateInsideStateMonad()
    {
        $state = put(12);

        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals(12, evalState($state, 1)(null));
    }

    public function testGetsAppliesProjectionFunctionToStateComponent()
    {
        $state = gets(function ($val) {
            return $val * 2;
        });

        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals([24, 12], evalState($state, null)(12));
    }

    public function testModifyFunctionMapsOldStateToNewState()
    {
        $state = modify(function ($val) {
            return ($val * 3) - 4;
        });
        
        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals([null, 2], evalState($state, null)(2));
    }

    public function testRunStateFunctionUnwrapsStateMonadComputationAsFunction()
    {
        $state = runState(State::of(12), 15);

        $this->assertInternalType('array', $state);
        $this->assertEquals([12, 15], $state);
    }

    public function testEvalStateFunctionOutputsFinalValue()
    {
        $state = evalState(State::of(3), 19);

        $this->assertEquals(3, $state);
    }

    public function testExecStateFunctionOutputsFinalState()
    {
        $state = execState(State::of(3), 12);

        $this->assertEquals(12, $state);
    }

    public function testApMethodOutputsNewAppliedState()
    {
        $fib = function ($val) use (&$fib) {
            return $val < 2 ? $val : $fib($val - 1) + $fib($val - 2);
        };

        $state = state(function ($val) use ($fib) {
            return $fib($val); 
        })
            ->ap(State::of(3))
            ->run(12);

        $this->assertEquals([2, 12], $state);
    }

    public function testBindFunctionChainsStateMonadTransformations()
    {
        $state = state(function ($val) {
            return pow($val, 4);
        })
            ->bind(function (callable $action) {
                return State::of($action(2));
            })
            ->run(1);
        
        $this->assertEquals([16, 1], $state);
    }

    public function testMapMethodChainsStateMonadTransformations()
    {
        $fact = function (int $val) use (&$fact) {
            return $val < 2 ? 1 : $val * $fact($val - 1);
        };

        $state = state(function ($val) use ($fact) {
            return $fact($val) / 2;
        })
            ->map(function (callable $action) {
                return $action(5);
            })
            ->run(2);

        $this->assertEquals([60, 2], $state);
    }
}