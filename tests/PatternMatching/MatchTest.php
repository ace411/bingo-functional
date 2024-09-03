<?php

namespace Chemem\Bingo\Functional\Tests\PatternMatching;

use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Functors\Monads\IO;
use Chemem\Bingo\Functional\PatternMatching as p;

class MatchTest extends \PHPUnit\Framework\TestCase
{
  public function cmatchProvider()
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
      [
        [
          '(x:_)' => function ($val) {
            return $val ** 2;
          },
          '_' => function () {
            return 'noop';
          },
        ],
        [[3], [3, 4], []],
        [9, 'noop', 'noop'],
      ],
    ];
  }

  /**
   * @dataProvider cmatchProvider
   */
  public function testcmatchComputesExactMatches($patterns, $entries, $res)
  {
    $eval   = p\cmatch($patterns);
    $result = [];

    foreach ($entries as $entry) {
      $result[] = $eval($entry);
    }

    $this->assertEquals($res, $result);
  }

  public function patternMatchProvider()
  {
    return [
      [
        [
          '["hello", name]'           => function ($name) {
            return f\concat(' ', 'Hello', $name);
          },
          \sprintf('"%s"', IO::class) => function () {
            return 'i/o';
          },
          '_'                         => function () {
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
          \sprintf('"%s"', \stdClass::class)  => function () {
            return 'std';
          },
          \sprintf('"%s"', IO::class)         => function () {
            return 'i/o';
          },
          '_'                                 => function () {
            return 'undefined';
          },
        ],
        [IO\IO(3), (object) [3, 'foo'], 'xyz'],
        ['i/o', 'std', 'undefined'],
      ],
      [
        [
          '[_, "bar"]'        => function () {
            return 2;
          },
          '["get", name]'     => function ($name) {
            return f\concat(' ', 'Hello', $name);
          },
          '["foo", 12]'       => function () {
            return 'foo-bar';
          },
          '[a, (x:xs), b]'    => function (...$args) {
            return f\mean(f\flatten($args));
          },
          '[12.224, _]'       => function () {
            return 'float';
          },
          '[_, name, "foo"]'  => function ($name) {
            return \sprintf('Hello, %s', $name);
          },
          '(a:b:c:d:e:_)'     => function (...$args) {
            return f\mean($args);
          },
          'a'                 => function ($value) {
            return \strtoupper($value);
          },
          '_'                 => function () {
            return 'undefined';
          },
        ],
        [
          ['get', 'World'],
          [3, [5, 8], 12],
          ['xyz'],
          [12, 'Loki', 'foo'],
          [12.224, 'baz'],
          ['foo', 12],
          'string',
          \range(1, 5),
        ],
        [
          'Hello World',
          7,
          'undefined',
          'Hello, Loki',
          'float',
          'foo-bar',
          'STRING',
          3,
        ],
      ],
    ];
  }

  /**
   * @dataProvider patternMatchProvider
   */
  public function testpatternMatchPerformsExhaustiveMatch($patterns, $entries, $res)
  {
    $eval   = f\partial(p\patternMatch, $patterns);
    $result = null;

    foreach ($entries as $entry) {
      $result[] = $eval($entry);
    }

    $this->assertEquals($res, $result);
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

  public static function extractProvider(): iterable
  {
    return [
      [
        '["foo", _, (x:xs)]',
        ['foo', null, \range(1, 3)],
        [
          'x'  => 1,
          'xs' => [1 => 2, 2 => 3],
        ],
      ],
      [
        '(x:xs:_)',
        \range(1, 5),
        [
          'x'   => 1,
          'xs'  => 2,
        ],
      ],
      [
        '[12.23, 2, _, a]',
        [12.23, 2, 'bar'],
        [],
      ],
      [
        'x',
        12,
        ['x' => 12],
      ],
      [
        'x',
        [24.2, ['foo', 'bar']],
        [
          'x' => [24.2, ['foo', 'bar']],
        ],
      ],
    ];
  }

  /**
   * @dataProvider extractProvider
   */
  public function testextractEffectsPatternBasedDestructuring(string $pattern, $input, $result)
  {
    $extracts = p\extract($pattern, $input);

    $this->assertEquals($result, $extracts);
  }
}
