<?php

namespace Chemem\Bingo\Functional\Tests;

use \Chemem\Bingo\Functional\Functors\Monads as M;
use \Chemem\Bingo\Functional\Functors\Maybe;

use function \Chemem\Bingo\Functional\Algorithms\concat;

class MonadHelperTest extends \PHPUnit\Framework\TestCase
{
    public function testMComposeFunctionComposesTwoMonadicFunctionsFromRightToLeft()
    {
        $res = M\mcompose(function ($contents) {
            return M\IO\IO(\strtolower($contents));
        }, M\IO\readFile)(M\IO\IO(concat('/', \dirname(__DIR__), 'io.test.txt')));

        $this->assertInstanceOf(M\IO::class, $res);
        $this->assertInternalType('string', $res->exec());
        $this->assertEquals('this is an io monad test file.', $res->exec());
    }

    public function testBindFunctionSequentiallyComposesTwoActions()
    {
        $res = M\bind(function ($val) {
            return M\IO\IO($val * 2);
        }, M\IO\IO(2));

        $this->assertInstanceOf(M\IO::class, $res);
        $this->assertEquals(4, $res->exec());
        $this->assertInternalType('integer', $res->exec());
    }

    public function testFoldMFunctionWorksLikeFoldFunction()
    {
        $fold = M\foldM(function (int $acc, int $val): M\Monadic {
            return $val < 3 ? M\IO::of($val + $acc) : M\IO::of($val - $acc);
        }, [4, 7, 9, 2, 1], 0);

        $this->assertInstanceOf(M\IO::class, $fold);
        $this->assertEquals(9, $fold->exec());
        $this->assertInternalType('integer', $fold->exec());
    }

    public function testFilterMPerformsFilterOperationInMonadicEnvironment()
    {
        $filter = M\filterM(function (int $val): M\Monadic {
            return Maybe\Maybe::just($val > 10);
        }, \range(1, 50));

        $this->assertInstanceOf(Maybe\Just::class, $filter);
        $this->assertEquals(\range(11, 50), $filter->getJust());
        $this->assertInternalType('array', $filter->getJust());
    }

    public function testMapMPerformsMapOperationInMonadicEnvironment()
    {
        $map = M\mapM(function (string $str): M\Monadic {
            return Maybe\Maybe::just(\strtoupper($str));
        }, ['foo', 'bar', 'baz']);

        $this->assertInstanceOf(Maybe\Just::class, $map);
        $this->assertEquals(['FOO', 'BAR', 'BAZ'], $map->getJust());
        $this->assertInternalType('array', $map->getJust());
    }
}
