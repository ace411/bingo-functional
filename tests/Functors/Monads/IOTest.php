<?php

namespace Chemem\Bingo\Functional\Tests\Functors\Monads;

\error_reporting(0);

use Eris\Generator;
use Chemem\Bingo\Functional as f;
use Chemem\Bingo\Functional\Functors\Monads\IO;
use Chemem\Bingo\Functional\Tests as t;

class IOTest extends \PHPUnit\Framework\TestCase
{
  use \Eris\TestTrait;

  private static $file;

  public static function setUpBeforeClass(): void
  {
    self::$file = __DIR__ . '/foo.txt';

    \file_put_contents(self::$file, 'foo-bar');
  }

  public static function tearDownAfterClass(): void
  {
    @unlink(self::$file);
  }

  /**
   * @test
   */
  public function IOMonadObeysFunctorLaws()
  {
    $this
      ->forAll(
        Generator\map(
          f\compose(IO\readFile, IO\catchIO),
          Generator\constant(self::$file)
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

  public function testreadFileSafelyReadsFileContents()
  {
    $impure = IO\catchIO(
      IO\readFile(self::$file)
    );
    $result = $impure->exec();

    $this->assertInstanceOf(IO::class, $impure);
    // $this->assertIsString($impure->exec());
    $this->assertTrue(
      \is_string($result)
    );
  }

  public function testappendFileSafelyAppendsDataToFile()
  {
    $append = IO\catchIO(
      IO\appendFile(self::$file, \sprintf("%s\n", 'fooz'))
    );
    $rbytes = $append->exec();

    $this->assertInstanceOf(IO::class, $append);
    $this->assertTrue(
      \is_string($rbytes) || \is_int($rbytes)
    );
  }

  public function testwriteFileSafelyWritesContentsToFile()
  {
    $write = IO\catchIO(
      IO\writeFile(self::$file, \sprintf("%s\n", 'bar'))
    );
    $rbytes = $write->exec();

    $this->assertInstanceOf(IO::class, $write);
    $this->assertTrue(
      \is_string($rbytes) || \is_int($rbytes)
      // \is_bool($write->exec()) || \is_int($write->exec())
    );
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
