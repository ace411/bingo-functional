<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class PageTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider(): array
  {
    return [
      [
        [10, 2],
        [10, 19],
      ],
      [
        [5, 3],
        [10, 14],
      ],
      [
        [1, 4],
        [3, 3],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testpageOutputsFirstAndLastItemsInSpecifiedRange($args, $result)
  {
    $page = f\page(...$args);

    $this->assertIsArray($page);
    $this->assertEquals($result, $page);
  }
}
