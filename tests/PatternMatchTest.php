<?php

use PHPUnit\Framework\TestCase;
use Chemem\Bingo\Functional\PatternMatching as PM;

class PatternMatchTest extends TestCase
{
    public function testGetNumConditionsFunctionOutputsArrayOfArities()
    {
        $numConditions = PM\getNumConditions(['(a:b:_)', '(a:_)', '_']);

        $this->assertEquals(
            $numConditions, 
            [
                '(a:b:_)' => 2, 
                '(a:_)' => 1, 
                '_' => 0
            ]
        );
    }

    public function testMatchFunctionComputesMatches()
    {
        $match = PM\match(
            [
                '(dividend:divisor:_)' => function (int $dividend, int $divisor) {
                    return $dividend / $divisor;
                },
                '(dividend:_)' => function (int $dividend) {
                    return $dividend / 2;
                },
                '_' => function () {
                    return 1;
                }
            ]
        );

        $result = $match([10, 5]);

        $this->assertEquals($result, 2);
    }
}