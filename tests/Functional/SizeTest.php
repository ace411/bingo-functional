<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use PHPUnit\Framework\TestCase;

use function Chemem\Bingo\Functional\size;

class SizeTest extends TestCase
{
  public static function contextProvider(): array
  {
    return [
      [\range(1, 5), 5],
      [(object) ['foo', 'bar', 'baz'], 3],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testsizeComputesSizeOfList($list, $result)
  {
    $size = size($list);

    $this->assertIsInt($size);
    $this->assertEquals($result, $size);
  }
}
