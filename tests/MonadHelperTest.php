<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\IO;
use function Chemem\Bingo\Functional\Algorithms\concat;
use function Chemem\Bingo\Functional\Functors\Monads\bind;
use function Chemem\Bingo\Functional\Functors\Monads\mcompose;

class MonadHelperTest extends \PHPUnit\Framework\TestCase
{
    public function testMComposeFunctionComposesTwoMonadicFunctionsFromRightToLeft()
    {
        $res = mcompose(function ($contents) {
            return IO\IO(strtolower($contents));
        }, IO\readFile)(IO\IO(concat('/', dirname(__DIR__), 'io.test.txt')));

        $this->assertInstanceOf(IO::class, $res);
        $this->assertInternalType('string', $res->exec());
        $this->assertEquals('this is an io monad test file.', $res->exec());
    }

    public function testBindFunctionSequentiallyComposesTwoActions()
    {
        $res = bind(function ($val) {
            return IO\IO($val * 2);
        }, IO\IO(2));

        $this->assertInstanceOf(IO::class, $res);
        $this->assertEquals(4, $res->exec());
        $this->assertInternalType('integer', $res->exec());
    }
}
