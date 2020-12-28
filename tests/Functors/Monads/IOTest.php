<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Monads;

\error_reporting(0);

use \Eris\Generator;
use Chemem\Bingo\Functional\Algorithms as f;
use Chemem\Bingo\Functional\Functors\Monads\IO;
use Chemem\Bingo\Functional\Tests as t;

class IOTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  /**
   * @test
   */
  public function IOMonadObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\map(
          IO\readFile,
          Generator\constant(__DIR__ . '/../../io.test.txt')
        )
      )
      ->then(function ($impure) {
        $fnx    = 'strtoupper';
        $fny    = f\partialRight(f\toWords, '/(\s)+/');

        $this->assertEquals([
          'identity'    => true,
          'composition' => true,
        ], t\functorLaws($impure, $fnx, $fny));
      });
  }

  /**
   * @test
   */
  public function IOObeysMonadLaws()
  {
    $this
      ->forAll(
          Generator\int()
      )
      ->then(function ($val) {
        $impure = IO\IO(function () use ($val) {
          return $val;
        });
        $fnx = function ($val) {
          return IO\IO($val ** 2);
        };
        $fny = function ($val) {
          return IO\IO($val + 10);
        };
        
        $this->assertEquals(
          [
            'left-identity'   => true,
            'right-identity'  => true,
            'associativity'   => true,
          ],
          t\monadLaws(
            $impure,
            $fnx,
            $fny,
            IO::of,
            $val
          )
        );
      });
  }

  public function readFileProvider()
  {
    return [
      [__DIR__ . '/../../io.test.txt'],
      [__DIR__ . '/foo.txt'],
    ];
  }

  /**
   * @dataProvider readFileProvider
   */
  public function testreadFileSafelyReadsFileContents($path)
  {
    $impure = IO\readFile($path);

    $this->assertInstanceOf(IO::class, $impure);
    $this->assertIsString($impure->exec());
  }

  public function writeFileProvider()
  {
    return [
      [__DIR__ . '/foo.txt', 'foo-bar'],
      [__DIR__ . '/file.php', '2'],
    ];
  }

  /**
   * @dataProvider writeFileProvider
   */
  public function testappendFileSafelyAppendsDataToFile($path, $contents)
  {
    $append = IO\appendFile($path, $contents);

    $this->assertInstanceOf(IO::class, $append);
    $this->assertTrue(\is_bool($append->exec()) || \is_int($append->exec()));
  }

  /**
   * @dataProvider writeFileProvider
   */
  public function testwriteFileSafelyWritesContentsToFile($path, $contents)
  {
    $write = IO\writeFile($path, $contents);

    $this->assertInstanceOf(IO::class, $write);
    $this->assertTrue(\is_bool($write->exec()) || \is_int($write->exec()));
  }

  public function IOExceptionProvider()
  {
    return [
      ['division by zero error'],
      ['non-existent file error'],
    ];
  }

  /**
   * @dataProvider IOExceptionProvider
   */
  public function testIOExceptionThrowsIOExceptionInsideIOMonad($msg)
  {
    $exception = IO\IOException($msg);

    $this->assertInstanceOf(IO::class, $exception);
    $this->assertInstanceOf(\Closure::class, $exception->exec());
    $this->assertEquals($msg, f\toException($exception->exec())());
  }

  /**
   * @dataProvider IOExceptionProvider
   */
  public function testcatchIOCatchesIOExceptionInIOMonadEnvironment($msg)
  {
    $error = IO\catchIO(IO\IOException($msg));

    $this->assertInstanceOf(IO::class, $error);
    $this->assertEquals($msg, $error->exec());
  }
}
