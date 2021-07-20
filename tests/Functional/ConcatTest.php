<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class ConcatTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [['foo', 'bar', 'baz'], ', ', 'foo, bar, baz'],
      [\range(1, 3), '->', '1->2->3'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testConcatConcatenatesMultipleStrings($items, $glue, $res)
  {
    $str = f\concat($glue, ...$items);

    $this->assertEquals($res, $str);
    // $this->assertIsString($str);
    $this->assertTrue(\is_string($str));
  }
}
