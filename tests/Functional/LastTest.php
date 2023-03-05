<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class LastTest extends \PHPunit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [[\range(1, 20)], 20],
      [[((object) ['foo', 'bar'])], 'bar'],
      [[[], 'undefined'], 'undefined'],
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
