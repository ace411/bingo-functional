<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\Reader;
use function Chemem\Bingo\Functional\Algorithms\concat;
use function Chemem\Bingo\Functional\Algorithms\fold;

class ReaderMonadTest extends \PHPUnit\Framework\TestCase
{
    public function testOfStaticMethodOutputsReaderInstance()
    {
        $this->assertInstanceOf(Reader::class, Reader::of(function ($name) {
            return 'Hello '.$name;
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

    public function testApMethodBuildsOnInitialReaderTransformation()
    {
        $read = Reader::of(function ($first) {
            return function ($last) use ($first) {
                return Reader::of(concat(' ', 'Hello', $first, $last));
            };
        })
            ->ap(Reader::of('Loki'))
            ->run('Agiro');

        $this->assertEquals('Hello Agiro Loki', $read);
        $this->assertInternalType('string', $read);
    }

    public function testWithReaderUsesCallbackToTransformInitialReaderValue()
    {
        $read = Reader::of(function ($name) {
            return concat(' ', 'Hello', $name.'.');
        })
            ->withReader(
                function ($content) {
                    return Reader::of(
                        function ($name) use ($content) {
                            return concat(' ', $content, ($name == 'Loki' ? '' : 'How are you?'));
                        }
                    );
                }
            );

        $this->assertEquals('Hello Loki. ', $read->run('Loki'));
        $this->assertEquals('Hello Michael. How are you?', $read->run('Michael'));
    }

    public function testWithReaderOutputsReaderInstance()
    {
        $read = Reader::of(function ($name) {
            return concat(' ', 'Hello', $name.'.');
        })
            ->withReader(
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

    public function testMapMethodUsesCallbackToTransformInitialReaderValue()
    {
        $read = Reader::of(function ($val) {
            return $val * 2;
        })
            ->map(function ($mult) {
                return Reader::of(function ($val) use ($mult) {
                    return $mult * ($val + 5);
                });
            })
            ->run(4);

        $this->assertEquals(72, $read);
    }

    public function testBindMethodOutputsReaderInstance()
    {
        $read = Reader::of(function ($nums) {
            return fold(function ($acc, $num) {
                return $acc + $num;
            }, $nums, 0);
        })
            ->bind(
                function ($sum) {
                    return Reader::of(function ($nums) use ($sum) {
                        return fold(function ($acc, $val) {
                            return $acc * $val;
                        }, $nums, $sum);
                    });
                }
            );

        $this->assertInstanceOf(Reader::class, $read);
    }

    public function testBindMethodUsesCallbackToTransformInitialReaderValue()
    {
        $read = Reader::of(function ($nums) {
            return fold(function ($acc, $num) {
                return $acc + $num;
            }, $nums, 0);
        })
            ->bind(
                function ($sum) {
                    return Reader::of(function ($nums) use ($sum) {
                        return fold(function ($acc, $val) {
                            return $acc * $val;
                        }, $nums, $sum);
                    });
                }
            )
            ->run(range(1, 3));

        $this->assertInternalType('integer', $read);
        $this->assertEquals(36, $read);
    }

    public function testAskMethodOutputsClosure()
    {
        $read = Reader::of(function ($name) {
            return concat(' ', 'Hello', $name);
        })
            ->ask();

        $this->assertInstanceOf(\Closure::class, $read);
    }
}
