<?php

use \Chemem\Bingo\Functional\Algorithms as f;
use \Chemem\Bingo\Functional\Immutable\Tuple as t;

class TupleTest extends \PHPUnit\Framework\TestCase
{
    public function sampleDataProvider()
    {
        return [
            [
                \range(1, 5),
                [2, 4]
            ]
        ];
    }
    
    /**
     * @dataProvider sampleDataProvider
     */
    public function testTupleStoresDataFromArray($data)
    {
        $tuple = t::from($data);

        $this->assertInstanceOf(t::class, $tuple);
    }

    /**
     * @dataProvider sampleDataProvider
     */
    public function testTupleOnlyOutputsValueCorrespondingToOffset($data, $result)
    {
        $tuple = t::from($data);

        $this->assertEquals(f\head($result), $tuple->get(1));
        $this->assertEquals(f\last($result), $tuple->get(3));
    }

    public function pairProvider()
    {
        return [
            [
                ['foo', false]
            ]
        ];
    }

    /**
     * @dataProvider pairProvider
     */
    public function testFstExtractsFirstComponentOfPair($pair)
    {
        $tup = t::from($pair);

        $this->assertEquals(f\head($pair), $tup->fst());
    }

    /**
     * @dataProvider pairProvider
     */
    public function testSndExtractsLastComponentOfPair($pair)
    {
        $tup = t::from($pair);

        $this->assertEquals(f\last($pair), $tup->snd());
    }

    /**
     * @dataProvider pairProvider
     */
    public function testSwapSwapsComponentsOfPair($pair)
    {
        $tup = t::from($pair)->swap();

        $this->assertEquals(f\last($pair), $tup->fst());
        $this->assertEquals(f\head($pair), $tup->snd());
    }
}
