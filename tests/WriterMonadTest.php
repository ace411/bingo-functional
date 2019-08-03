<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\Writer;
use function Chemem\Bingo\Functional\Algorithms\extend;
use function Chemem\Bingo\Functional\Functors\Monads\Writer\execWriter;
use function Chemem\Bingo\Functional\Functors\Monads\Writer\mapWriter;
use function Chemem\Bingo\Functional\Functors\Monads\Writer\runWriter;
use function Chemem\Bingo\Functional\Functors\Monads\Writer\writer;

class WriterMonadTest extends \PHPUnit\Framework\TestCase
{
    public function testOfStaticMethodOutputsInstanceOfWriterMonad()
    {
        $this->assertInstanceOf(Writer::class, Writer::of(12, 'Received 12'));
    }

    public function testRunWriterUnwrapsWriterComputationAsResultOutputPair()
    {
        $pair = runWriter(writer(1, 13));

        $this->assertInternalType('array', $pair);
        $this->assertEquals([1, [13]], $pair);
    }

    public function testExecWriterExtractsOutputFromWriter()
    {
        $writer = execWriter(writer(12, 19));

        $this->assertEquals([19], $writer);
        $this->assertInternalType('array', $writer);
    }

    public function testMapWriterMapsFunctionOntoBothReturnValueAndOutputOfWriter()
    {
        $result = mapWriter(
            function (array $writer) {
                list($res) = $writer;
                $new = $res * 2;

                return extend([$new], [$new % 2 == 0 ? 'even' : 'odd']);
            },
            writer(19, 'odd')
        );

        $this->assertInstanceOf(Writer::class, $result);
        $this->assertEquals([38, ['even']], runWriter($result));
    }

    public function testApMethodOutputsWriterMonadInstance()
    {
        $val = Writer::of(function ($val) {
            return $val * 2;
        }, 'Received lambda')
            ->ap(Writer::of(12, 'Applied 12 to lambda'));

        $this->assertInstanceOf(Writer::class, $val);
    }

    public function testBindMethodUpdatesWriter()
    {
        $writer = writer(12, 'int')
            ->bind(function ($val) {
                return writer((float) ($val / 3), 'float');
            });

        $this->assertInstanceOf(Writer::class, $writer);
        $this->assertInternalType('array', runWriter($writer));
        $this->assertEquals([(float) 4.0, ['int', 'float']], runWriter($writer));
    }

    public function testMapMethodTransformsInnerValue()
    {
        $writer = Writer\writer(12, 'int')
            ->map(function (int $val) {
                return ($val - 2) / 5;
            });

        $this->assertInstanceOf(Writer::class, $writer);
        $this->assertInternalType('array', runWriter($writer));
        $this->assertEquals([2, ['int']], runWriter($writer));
    }

    public function testTellFunctionProducesMonadOutput()
    {
        $writer = Writer\tell('add 2')->map(function ($res) {
            return $res + 2;
        });

        $this->assertInstanceOf(Writer::class, $writer);
        $this->assertInternalType('array', runWriter($writer));
        $this->assertEquals([2, ['add 2']], runWriter($writer));
    }
}
