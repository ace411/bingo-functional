<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class HeadTest extends \PHPunit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [[\range(1, 20)], 1],
      [[(object) ['foo', 'bar']], 'foo'],
      [[[], 0], 0],
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
