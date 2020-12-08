<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Monads;

\error_reporting(0);

use \Eris\Generator;
use Chemem\Bingo\Functional\Algorithms as f;
use Chemem\Bingo\Functional\Functors\Monads\State;
use Chemem\Bingo\Functional\Tests as t;

class StateTest extends \PHPUnit\Framework\TestCase
{
    use \Eris\TestTrait;

    /**
     * @test
     */
    public function StateObeysFunctorLaws()
    {
        $this
      ->forAll(
          Generator\int()
      )
      ->then(function ($val) {
          $functor  = State::of($val);
          $fnx      = function ($res) {
              return $res ** 2;
          };
          $fny      = function ($res) {
              return $res + 10;
          };

          $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], t\functorLaws($functor, $fnx, $fny));
      });
    }

    /**
     * @test
     */
    public function StateObeysMonadLaws()
    {
        $this
      ->forAll(
          Generator\int(),
          Generator\names()
      )
      ->then(function ($val, $state) {
          $monad  = State::of($val);
          $fnx    = function ($res) {
              return State::of($res ** 2);
          };
          $fny    = function ($res) {
              return State::of($res + 10);
          };

          $this->assertEquals(
              [
            'left-identity'   => true,
            'right-identity'  => true,
            'associativity'   => true,
          ],
              t\monadLaws(
              $monad,
              $fnx,
              $fny,
              State::of,
              $val,
              $state
          )
          );
      });
    }

    public function stateProvider()
    {
        return [
      [f\identity],
      [function ($val) {
          return $val ** 2;
      }],
    ];
    }

    /**
     * @dataProvider stateProvider
     */
    public function teststateEmbedsFunctionInStateMonad($action)
    {
        $state  = State\state($action);
        [$fst,] = $state->run(2);

        $this->assertInstanceOf(State::class, $state);
        $this->assertInstanceOf(\Closure::class, $fst);
    }

    public function putProvider()
    {
        return [[3], ['foo']];
    }

    /**
     * @dataProvider putProvider
     */
    public function testputReplacesStateInsideStateMonad($val)
    {
        $state  = State\put($val);
        [$fst,] = $state->run(null);

        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals($val, $fst(null));
    }

    public function getsProvider()
    {
        return [
      [
        function ($val) {
            return $val ** 2;
        },
        2,
        [4, 2],
      ],
      [
        f\partial(f\concat, '-', 'foo'),
        'bar',
        ['foo-bar', 'bar'],
      ],
    ];
    }

    /**
     * @dataProvider getsProvider
     */
    public function testgetsSpecificComponentOfStateUsingProjectionFunction($projection, $arg, $res)
    {
        $state = State\gets($projection);

        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals($res, State\evalState($state, null)($arg));
    }

    public function modifyProvider()
    {
        return [
      [
        function ($val) {
            return $val ** 2;
        },
        2,
        [null, 4],
      ],
      [
        function ($val) {
            return f\concat('-', 'foo', $val);
        },
        'bar',
        [null, 'foo-bar'],
      ],
    ];
    }

    /**
     * @dataProvider modifyProvider
     */
    public function testModifyMapsOldStateOntoNewState($func, $val, $res)
    {
        $state = State\modify($func);

        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals($res, State\evalState($state, null)($val));
    }

    public function runStateProvider()
    {
        return [
      [2, 3, [2, 3]],
      ['foo', 12, ['foo', 12]]
    ];
    }

    /**
     * @dataProvider runStateProvider
     */
    public function testrunStateUnwrapsStateMonadComputation($init, $final, $res)
    {
        $state = State\runState(State::of($init), $final);

        $this->assertEquals($res, $state);
    }
}
