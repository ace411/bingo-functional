<?php

namespace Chemem\Bingo\Functional\Tests\PatternMatching;

use Chemem\Bingo\Functional\Algorithms as f;
use Chemem\Bingo\Functional\Functors\Monads\IO;
use Chemem\Bingo\Functional\PatternMatching as p;

class MatchTest extends \PHPUnit\Framework\TestCase
{
  public function matchProvider()
  {
    return [
      [
        [
          '(x:xs:_)' => function ($fst, $snd) {
            return $fst / $snd;
          },
          '(x:_)' => function ($fst) {
            return $fst / 2;
          },
          '_' => function () {
            return 0;
          },
        ],
        [[4, 2], [12], []],
        [2, 6, 0],
      ],
    ];
  }

  /**
   * @dataProvider matchProvider
   */
  public function testmatchComputesExactMatches($patterns, $entries, $res)
  {
    $eval                 = p\match($patterns);
    [$fst, $snd, $thd]    = $entries;
    [$rfst, $rsnd, $rthd] = $res;
    
    $this->assertEquals($rfst, $eval($fst));
    $this->assertEquals($rsnd, $eval($snd));
    $this->assertEquals($rthd, $eval($thd));
  }

  public function patternMatchProvider()
  {
    return [
      [
        [
          '["hello", name]' => function ($name) {
            return f\concat(' ', 'Hello', $name);
          },
          IO::class => function () {
            return 'i/o';
          },
          '_' => function () {
            return 'undefined';
          },
        ],
        [IO::of(3), ['hello', 'World'], 'pennies'],
        ['i/o', 'Hello World', 'undefined'],
      ],
      [
        [
          '"1"' => function () {
            return 1;
          },
          '"foo"' => function () {
            return 'fooz';
          },
          '_' => function () {
            return 'undefined';
          },
        ],
        ['1', 'foo', 'undef'],
        [1, 'fooz', 'undefined'],
      ],
      [
        [
          \stdClass::class => function () {
            return 'std';
          },
          IO::class => function () {
            return 'i/o';
          },
          '_' => function () {
            return 'undefined';
          },
        ],
        [IO\IO(3), (object) [3, 'foo'], 'xyz'],
        ['i/o', 'std', 'undefined'],
      ],
      [
        [
          '[_, "bar"]' => function () {
            return 2;
          },
          '["get", name]' => function ($name) {
            return f\concat(' ', 'Hello', $name);
          },
          '["foo", "baz"]' => function () {
            return 'foo-bar';
          },
          '[a, (x:xs), b]' => function () {
            return 12;
          },
          '_' => function () {
            return 'undefined';
          },
        ],
        [
          ['get', 'World'],
          [3, ['foo', 'bar'], 'baz'],
          ['xyz'],
        ],
        ['Hello World', 12, 'undefined'],
      ],
    ];
  }

  /**
   * @dataProvider patternMatchProvider
   */
  public function testpatternMatchPerformsExhaustiveMatch($patterns, $entries, $res)
  {
    $eval                 = f\partial(p\patternMatch, $patterns);
    [$fst, $snd, $thd]    = $entries;
    [$rfst, $rsnd, $rthd] = $res;

    $this->assertEquals($rfst, $eval($fst));
    $this->assertEquals($rsnd, $eval($snd));
    $this->assertEquals($rthd, $eval($thd));
  }

  public function letInProvider()
  {
    return [
      [
        \range(1, 3),
        '[a, b, _]',
        ['b'],
        function ($res) {
          return $res ** 2;
        },
        4,
      ],
      [
        ['foo', 'bar', ['baz', 'fooz']],
        '[a, _, (x:xs)]',
        ['x', 'xs'],
        function ($fst, $snd) {
          return f\concat('_', $fst, ...$snd);
        },
        'baz_fooz',
      ],
    ];
  }

  /**
   * @dataProvider letInProvider
   */
  public function testletInPerformsDestructuringByPatternMatching(
    $list,
    $pattern,
    $arg,
    $func,
    $res
  ) {
    $let = p\letIn($pattern, $list);

    $this->assertEquals($res, $let($arg, $func));
  }
}
