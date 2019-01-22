<?php

namespace Chemem\Bingo\Functional\Tests;

use \Chemem\Bingo\Functional\Functors\Monads as M;
use function \Chemem\Bingo\Functional\Algorithms\concat;

class MonadHelperTest extends \PHPUnit\Framework\TestCase
{
    public function testMComposeFunctionComposesTwoMonadicFunctionsFromRightToLeft()
    {
        $res = M\mcompose(function ($contents) {
            return M\IO\IO(strtolower($contents));
        }, M\IO\readFile)(M\IO\IO(concat('/', dirname(__DIR__), 'io.test.txt')));

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
}
