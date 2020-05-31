<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use function Chemem\Bingo\Functional\Functors\Monads\ListMonad\append;
use function Chemem\Bingo\Functional\Functors\Monads\ListMonad\concat;
use function Chemem\Bingo\Functional\Functors\Monads\ListMonad\fromValue;
use function Chemem\Bingo\Functional\Functors\Monads\ListMonad\head;
use function Chemem\Bingo\Functional\Functors\Monads\ListMonad\prepend;
use function Chemem\Bingo\Functional\Functors\Monads\ListMonad\tail;

class ListMonadTest extends \PHPUnit\Framework\TestCase
{
    public function testOfStaticMethodReturnsListMonadInstance()
    {
        $this->assertInstanceOf(ListMonad::class, ListMonad::of(\range(1, 5)));
    }

    public function testConcatFunctionMergesMultipleLists()
    {
        $list = concat(fromValue(\range(1, 4)), fromValue(\range(5, 10)));

        $this->assertInstanceOf(ListMonad::class, $list);
        $this->assertEquals(\range(1, 10), $list->extract());
        $this->assertInternalType('array', $list->extract());
    }

    public function testPrependAddsOneListToBeginningOfAnother()
    {
        $list = prepend(fromValue(\range(1, 3)), fromValue(\range(5, 7)));

        $this->assertInstanceOf(ListMonad::class, $list);
        $this->assertEquals([1, 2, 3, 5, 6, 7], $list->extract());
    }

    public function testAppendAddsOneListToEndOfAnother()
    {
        $list = append(fromValue(\range(1, 3)), fromValue(['foo', 'bar']));

        $this->assertInstanceOf(ListMonad::class, $list);
        $this->assertEquals(['foo', 'bar', 1, 2, 3], $list->extract());
    }

    public function testHeadFunctionOutputsFirstElementInList()
    {
        $this->assertEquals(1, head(fromValue(\range(1, 3))));
    }

    public function testTailFunctionOutputsLastElementInList()
    {
        $this->assertEquals(3, tail(fromValue(\range(1, 3))));
    }

    public function testBindMethodGeneratesZipList()
    {
        $zip = fromValue(\range(1, 3))
            ->bind(function (int $val) {
                return fromValue($val * 2);
            });

        $this->assertInstanceOf(ListMonad::class, $zip);
        $this->assertEquals([1, 2, 3, 2, 4, 6], $zip->extract());
    }

    public function testMapMethodGeneratesZipList()
    {
        $zip = fromValue(\range(1, 3))
            ->map(function (int $val) {
                return $val + 1;
            });

        $this->assertInstanceOf(ListMonad::class, $zip);
        $this->assertEquals([1, 2, 3, 2, 3, 4], $zip->extract());
    }

    public function testFlatMapFunctionOutputsZipListAsArray()
    {
        $zip = fromValue(['foo', 'bar'])
            ->flatMap('strtoupper');

        $this->assertInternalType('array', $zip);
        $this->assertEquals(['foo', 'bar', 'FOO', 'BAR'], $zip);
    }
}
