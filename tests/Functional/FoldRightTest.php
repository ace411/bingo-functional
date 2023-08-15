<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use PHPUnit\Framework\TestCase;

use function Chemem\Bingo\Functional\foldRight;

class FoldRightTest extends TestCase
{
  public static function contextProvider(): array
  {
    return [
      [
        function ($acc, $val) {
          return $acc . '-' . $val;
        },
        (object) ['foo', 'bar', 'baz'],
        '',
        '-baz-bar-foo',
      ],
      [
        function ($acc, $val) {
          return $acc / $val;
        },
        [12, 2, 1],
        1,
        (0.5 / 12),
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testfoldRightPerformsFoldOperationInReverseOrder($func, $list, $acc, $result)
  {
    $fold = foldRight($func, $list, $acc);

    $this->assertEquals($result, $fold);
  }
}
