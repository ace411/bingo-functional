<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Monads;

\error_reporting(0);

use Eris\Generator;
use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Functors\Monads\Reader;
use Chemem\Bingo\Functional\Tests as t;

class ReaderTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function ReaderObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\names()
      )
      ->then(function ($env) {
        $reader = Reader\reader(function ($name) {
          return f\concat(' ', 'Hello', $name);
        });

        $fnx = f\partial(f\concat, ' ', 'foo:');
        $fny = f\partial(f\concat, ' ', 'bar:');

        $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], t\functorLaws($reader, $fnx, $fny, $env));
      });
  }

  /**
   * @test
   */
  public function ReaderObeysMonadLaws()
  {
    $this
      ->forAll(
        Generator\int()
      )
      ->then(function ($env) {
        $reader = Reader\reader($env);
        $fnx = function ($val) {
          return Reader\reader($val ** 2);
        };
        $fny = function ($val) {
          return Reader\reader($val + 10);
        };

        $this->assertEquals(
          [
            'left-identity'   => true,
            'right-identity'  => true,
            'associativity'   => true,
          ],
          t\monadLaws(
            $reader,
            $fnx,
            $fny,
            Reader::of,
            $env,
            $env
          )
        );
      });
  }

  public function askProvider()
  {
    return [
      [2],
      ['foo'],
      [new \stdClass(3)],
      [\range(1, 4)],
    ];
  }

  /**
   * @dataProvider askProvider
   */
  public function testaskRetrievesMonadEnvironment($res)
  {
    $env = Reader\reader($res)->ask();

    $this->assertInstanceOf(Reader::class, $env);
    $this->assertEquals($res, $env->run($res));
  }

  public function withReaderProvider()
  {
    return [
      [
        f\partial(f\concat, ' ', 'Hello'),
        function ($greeting) {
          return Reader\reader(function ($name) use ($greeting) {
            return f\concat('', $greeting, $name == 'world' ? '' : '. How are you?');
          });
        },
        ['ace411', 'world', 'mike'],
        ['Hello ace411. How are you?', 'Hello world', 'Hello mike. How are you?'],
      ],
    ];
  }

  /**
   * @dataProvider withReaderProvider
   */
  public function testwithReaderExecutesComputationInModifiedEnvironment($fst, $snd, $env, $res)
  {
    $reader = Reader\withReader($snd, Reader\reader($fst));
    $check  = f\fold(function ($acc, $name) use ($reader) {
      $acc[] = $reader->run($name);

      return $acc;
    }, $env, []);

    $this->assertEquals($res, $check);
  }

  public function mapReaderProvider()
  {
    return [
      [
        f\identity,
        function ($val) {
          return $val ** 2;
        },
        2,
        4,
      ],
      [
        function ($val) {
          return $val + 10;
        },
        function ($val) {
          return ($val + 10) / 2;
        },
        4,
        12,
      ],
    ];
  }

  /**
   * @dataProvider mapReaderProvider
   */
  public function testmapReaderTransformsValueReturnedByReader($fnx, $fny, $val, $res)
  {
    $reader = Reader\mapReader($fny, Reader\reader($fnx));

    $this->assertEquals($res, $reader->run($val));
  }
}
