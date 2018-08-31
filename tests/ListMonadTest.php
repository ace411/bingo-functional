<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Functors\Monads\ListMonad;

class ListMonadTest extends \PHPUnit\Framework\TestCase
{
    public function testOfStaticMethodReturnsListMonadInstance()
    {
        $this->assertInstanceOf(ListMonad::class, ListMonad::of(range(1, 5)));
    }

    public function testApMethodOutputsListMonadInstance()
    {
        $zip = ListMonad::of(range(1, 3))
            ->ap(ListMonad::of([function ($val) {
                return $val * 2;
            }, function ($val) {
                return $val + 1;
            }]));

        $this->assertInstanceOf(ListMonad::class, $zip);
    }

    public function testApMethodGeneratesZipListByApplyingEachFunctionInListToCurrentCollection()
    {
        $zip = ListMonad::of(range(1, 3))
            ->ap(ListMonad::of([function ($val) {
                return $val * 2;
            }, function ($val) {
                return $val + 1;
            }]))
            ->extract();

        $this->assertInternalType('array', $zip);
        $this->assertEquals([1, 2, 3, 2, 4, 6, 2, 3, 4], $zip);
    }

    public function testMapMethodReturnsInstanceOfListMonad()
    {
        $zip = ListMonad::of(range(1, 5))
            ->map(function ($val) {
                return $val * 2;
            });

        $this->assertInstanceOf(ListMonad::class, $zip);
    }

    public function testMapMethodGeneratesZipList()
    {
        $zip = ListMonad::of(['foo', 'bar', 'baz'])
            ->map('strtoupper')
            ->extract();

        $this->assertInternalType('array', $zip);
        $this->assertEquals(['FOO', 'BAR', 'BAZ', 'foo', 'bar', 'baz'], $zip);
    }

    public function testBindMethodReturnsInstanceOfListMonad()
    {
        $zip = ListMonad::of(range(1, 5))
            ->bind(function ($val) {
                return $val * 2;
            });

        $this->assertInstanceOf(ListMonad::class, $zip);
    }

    public function testFlatMapMethodOutputsArray()
    {
        $zip = ListMonad::of(['foo', 'bar', 'baz'])
            ->flatMap('strtoupper');

        $this->assertInternalType('array', $zip);
    }
}
