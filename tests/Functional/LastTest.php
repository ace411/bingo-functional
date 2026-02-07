<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class LastTest extends \PHPunit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [[\range(1, 20)], 20],
      [[((object) ['foo', 'bar'])], 'bar'],
      [[[], 'undefined'], 'undefined'],
      [
        [
          new class () {
            public $x = true;
            public $y = 'foo';
            public $z = 1.2221;
          },
        ],
        1.2221,
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
  public function testlastComputesTheFinalValueInAList(array $args, $res)
  {
    $last = f\last(...$args);

    $this->assertEquals($res, $last);
  }
}
