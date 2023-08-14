<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class AnyTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [['foo', 'bar', 1, 3, \range(5, 9)], 'is_string', true],
      [(object) ['foo' => 'foo', 'bar' => 'bar'], 'is_int', false],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testanyChecksIfAnyElementInCollectionConformsToBooleanPredicate($list, $func, $res)
  {
    $any = f\any($list, $func);

    $this->assertEquals($res, $any);
  }
}
