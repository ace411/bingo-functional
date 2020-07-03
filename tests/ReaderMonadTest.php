<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\Reader;

use function Chemem\Bingo\Functional\Algorithms\concat;
use function Chemem\Bingo\Functional\Algorithms\fold;
use function Chemem\Bingo\Functional\Functors\Monads\Reader\ask;
use function Chemem\Bingo\Functional\Functors\Monads\Reader\mapReader;
use function Chemem\Bingo\Functional\Functors\Monads\Reader\reader;
use function Chemem\Bingo\Functional\Functors\Monads\Reader\runReader;
use function Chemem\Bingo\Functional\Functors\Monads\Reader\withReader;

class ReaderMonadTest extends \PHPUnit\Framework\TestCase
{
    public function testOfStaticMethodOutputsReaderInstance()
    {
        $this->assertInstanceOf(Reader::class, reader(function ($name) {
            return 'Hello ' . $name;
        }));
    }

    public function testApMethodOuputsReaderInstance()
    {
        $read = Reader::of(function ($first) {
            return function ($last) use ($first) {
                return Reader::of(concat(' ', 'Hello', $first, $last));
            };
        })
            ->ap(Reader::of('Loki'));

        $this->assertInstanceOf(Reader::class, $read);
    }

    public function testBindMethodUsesCallbackToTransformInitialReaderValue()
    {
        $read = Reader::of(function ($name) {
            return concat(' ', 'Hello', $name . '.');
        })
            ->bind(
                function ($content) {
                    return Reader::of(function ($name) use ($content) {
                        return concat(' ', $content, ($name == 'Loki' ? '' : 'How are you?'));
                    });
                }
            );

        $this->assertEquals('Hello Loki. ', $read->run('Loki'));
        $this->assertEquals('Hello Michael. How are you?', $read->run('Michael'));
    }

    public function testBindMethodOutputsReaderInstance()
    {
        $read = Reader::of(function ($name) {
            return concat(' ', 'Hello', $name . '.');
        })
            ->bind(
                function ($content) {
                    return Reader::of(
                        function ($name) use ($content) {
                            return concat(' ', $content, ($name == 'Loki' ? '' : 'How are you?'));
                        }
                    );
                }
            );

        $this->assertInstanceOf(Reader::class, $read);
    }

    public function testMapMethodOutputsReaderInstance()
    {
        $read = Reader::of(function ($val) {
            return $val * 2;
        })
            ->map(function ($mult) {
                return Reader::of(function ($val) use ($mult) {
                    return $mult * ($val + 5);
                });
            });

        $this->assertInstanceOf(Reader::class, $read);
    }

    public function testAskMethodOutputsClosure()
    {
        $read = Reader::of(function ($name) {
            return concat(' ', 'Hello', $name);
        })
            ->ask();

        $this->assertInstanceOf(\Closure::class, $read);
    }

    public function testRunReaderRunsReaderAndExtractsFinalValue()
    {
        $read = runReader(
            reader(function (int $val) {
                return $val * 2;
            }),
            12
        );

        $this->assertEquals(24, $read);
    }

    public function testMapReaderTransformsValueReturnedByReader()
    {
        $reader = mapReader(
            'strtoupper',
            reader(function (string $val) {
                return concat('-', 'foo', $val);
            })
        );

        $this->assertInstanceOf(Reader::class, $reader);
        $this->assertEquals('FOO-BAR', runReader($reader, 'bar'));
    }

    public function testWithReaderExecutesComputationInModifiedEnvironment()
    {
        $reader = withReader(
            function ($sum) {
                return reader(function (array $ints) use ($sum) {
                    return $sum / \count($ints);
                });
            },
            reader(function (array $ints) {
                return fold(
                    function (int $acc, int $val) {
                        return $acc + $val;
                    },
                    $ints,
                    0
                );
            })
        );

        $this->assertInstanceOf(Reader::class, $reader);
        $this->assertEquals(3, runReader($reader, [3, 2, 4]));
    }

    public function testAskFunctionRetrievesMonadEnvironment()
    {
        $this->assertInstanceOf(Reader::class, ask());
    }
}
