<?php

use PHPUnit\Framework\TestCase;
use Chemem\Bingo\Functional\Common\Monads\MonadAbstract;
use Chemem\Bingo\Functional\Functors\Monads\Monad;
use Chemem\Bingo\Functional\Functors\Applicatives\Applicative;

class MonadTest extends TestCase
{
    public function testMonadReturnIsSimilarToApplicativePure()
    {
        $val = Monad::return(12);
        $this->assertSame(
            $val->getValue(),
            Applicative::pure(12)->getValue()
        );
    }

    public function testMonadBindMapsFunctionOntoMonadValue()
    {
        $addTen = function (int $val) : int {
            return $val + 10;
        };
        $val = Monad::return(12)
            ->bind($addTen);

        $this->assertEquals($val->getValue(), 22);
        $this->assertInstanceOf(MonadAbstract::class, $val);
        $this->assertEquals($val, Monad::return(12)->map($addTen));
    }

    public function testFilterFunctionFiltersWrappedValue()
    {
        $val = Monad::return(12)
            ->filter('is_int');

        $this->assertEquals($val->getValue(), 12);
        $this->assertInstanceOf(MonadAbstract::class, $val);
    }

    public function testFlatMapFunctionReturnsNonEncapsulatedValue()
    {
        $multiplyByTen = function (int $a) : int {
            return $a * 10;
        };

        $val = Monad::return(5)
            ->filter('is_int')
            ->flatMap($multiplyByTen);

        $this->assertEquals($val, 50);    
    }
}
