<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class EveryTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [['foo', 'bar', 1, 3, \range(5, 9)], 'is_string', false],
      [(object) ['foo', 'bar'], 'is_string', true],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testEveryChecksIfEveryElementInCollectionConformsToBooleanPredicate($list, $func, $res)
  {
    $any = f\every($list, $func);

    $this->assertEquals($res, $any);
  }
}
