<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class HeadTest extends \PHPunit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [[\range(1, 20)], 1],
      [[(object) ['foo', 'bar']], 'foo'],
      [[[], 0], 0],
      [
        [
          new class () {
            public $x = 12;
            public $y = 'quux';
            public $z = false;
          },
        ],
        12,
      ],
      [
        [
          (object) [],
          0,
        ],
        0,
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testheadComputesTheFirstValueInAList($args, $res)
  {
    $head = f\head(...$args);

    $this->assertEquals($res, $head);
  }
}
