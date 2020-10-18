<?php

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Algorithms as f;
use Chemem\Bingo\Functional\Functors\Lens as l;
use \PHPUnit\Framework\TestCase;

class LensTest extends TestCase
{
    public function lensLaws($get, $set, $store, $val = null)
    {
        $lens = l\lens($get, $set);

        return [
          'fst' => l\view($lens, l\set($lens, $val, $store)) == $val,
          'snd' => l\set($lens, $val, l\set($lens, 'foo', $store)) == l\set($lens, $val, $store),
          'thd' => l\set($lens, l\view($lens, $store), $store) == $store
        ];
    }

    public function storeProvider()
    {
        return [
          [
            ['x' => 'foo', 'y' => 'bar', 'z' => 'baz'],
            (object) ['x' => 'foo', 'y' => 'bar'],
          ]
        ];
    }

    /**
     * @dataProvider storeProvider
     */
    public function testLensLawsHold($data)
    {
        $laws = $this->lensLaws(
            f\partialRight(f\pluck, 'x'),
            f\curry(f\assoc)('x'),
            $data,
            2
        );

        $this->assertEquals([
          'fst' => true,
          'snd' => true,
          'thd' => true
        ], $laws);
    }

    public function testLensBuildsLensOutOfGetterAndSetter()
    {
        $lens = l\lens(f\partial(f\pluck, 'x'), f\curry(f\assoc)('x'));

        $this->assertInstanceOf(\Closure::class, $lens);
    }

    public function testLensKeyCreatesLensWhoseFocusIsSpecifiedKey()
    {
        $lens = l\lensKey('x');

        $this->assertInstanceOf(\Closure::class, $lens);
    }

    /**
     * @dataProvider storeProvider
     */
    public function testViewExtractsFocusOfLens($data)
    {
        $lens = l\lensKey('x');
        $view = l\view($lens, $data);

        $this->assertInternalType('string', $view);
        $this->assertEquals('foo', $view);
    }

    /**
     * @dataProvider storeProvider
     */
    public function testOverAppliesFunctionToFocusOfLens($data)
    {
        $lens = l\lens(f\partial(f\pluck, 'x'), f\curry(f\assoc)('x'));
        $res  = l\over($lens, 'strtoupper', $data);
    
        $this->assertTrue(\is_array($res) || \is_object($res));
        $this->assertInternalType('string', f\pluck($res, 'x'));
    }

    /**
     * @dataProvider storeProvider
     */
    public function testSetUpdatesEntityAssociatedWithFocusOfLens($data)
    {
        $lens = l\lensKey('x');
        $res  = l\set($lens, 33, $data);

        $this->assertTrue(\is_array($res) || \is_object($res));
        $this->assertEquals(33, f\pluck($res, 'x'));
    }
  
    public function testLensPathCreatesLensFromListPath()
    {
        $arr = [
          \range(1, 3),
          'foo' => [
            'bar' => \range(4, 6),
            ['baz', 'fooz']
          ]
        ];
        $obj = (object) $arr;

        $lens = l\lensPath('foo', 0, 1);
        $over = f\partial(l\over, $lens, 'strtoupper');

        $this->assertInstanceOf(\Closure::class, $lens);
        $this->assertEquals([
          \range(1, 3),
          'foo' => [
            'bar' => \range(4, 6),
            ['baz', 'FOOZ']
          ]
        ], $over($arr));
    
        $this->assertEquals((object) [
          \range(1, 3),
          'foo' => [
            'bar' => \range(4, 6),
            ['baz', 'FOOZ']
          ]
        ], $over($obj));
    }
}
