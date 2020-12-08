<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Monads;

\error_reporting(0);

use \Eris\Generator;
use Chemem\Bingo\Functional\{
  Functors\Monads\Writer,
  Algorithms as f,
  Tests as t
};

class WriterTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function WriterObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\map(function ($int) {
          return [$int, f\concat(' ', 'put', $int)];
        }, Generator\int())
      )
      ->then(function ($input) {
        $writer = Writer::of(...$input);
        $fnx = function ($res) {
          return $res ** 2;
        };

        $fny = function ($res) {
          return $res + 10;
        };

        $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], t\functorLaws($writer, $fnx, $fny));
      });
  }

  /**
   * @test
   */
  public function WriterObeysMonadLaws()
  {
    $this
      ->forAll(
        Generator\int()
      )
      ->then(function ($input) {
        $writer = Writer::of($input);
        $fnx    = function ($res) {
          return Writer::of($res ** 2, 'square');
        };
        $fny    = function ($res) {
          return Writer::of($res + 10, 'add 10');
        };

        $this->assertEquals(
          [
            'left-identity'   => true,
            'right-identity'  => true,
            'associativity'   => true,
          ],
          t\monadLaws(
            $writer,
            $fnx,
            $fny,
            Writer::of,
            $input
          )
        );
      });
  }

  public function tellProvider()
  {
    return [['foo'], [12]];
  }

  /**
   * @dataProvider tellProvider
   */
  public function testtellProducesWriterMonadOutput($val)
  {
    $tell   = Writer\tell($val);
    $output = Writer\execWriter($tell);

    $this->assertInstanceOf(Writer::class, $tell);
    $this->assertEquals([$val], $output);
  }

  public function mapWriterProvider()
  {
    return [
      [
        function ($writer) {
          [$result, [$output]] = $writer;

          return [$result ** 2, $output % 2 == 0 ? 'even' : 'odd'];
        },
        [2, 5],
        [4, ['odd']],
      ],
      [
        function ($writer) {
          [$result, [$output]] = $writer;

          return [
            f\concat('-', 'foo', $result),
            f\concat(':', $output, 'bar'),
          ];
        },
        ['foo', 'bar'],
        ['foo-foo', ['bar:bar']],
      ],
    ];
  }

  /**
   * @dataProvider mapWriterProvider
   */
  public function testmapWriterTransformsBothReturnAndOuputWriterValues($func, $data, $res)
  {
    $writer = Writer\mapWriter($func, Writer\writer(...$data));

    $this->assertInstanceOf(Writer::class, $writer);
    $this->assertEquals($res, $writer->run());
  }
}
