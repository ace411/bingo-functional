<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class ContainsTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      ['bingo-functional', 'func', true],
      ['agiroLoki', 'chemem', false],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testcontainsChecksIfStringContainsStringFragment($str, $frag, $res)
  {
    $contains = f\contains($str, $frag);

    $this->assertEquals($res, $contains);
  }
}
