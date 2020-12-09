<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class HeadTest extends \PHPunit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [\range(1, 20), 1],
      [(object) ['foo', 'bar'], 'foo'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testheadComputesTheFirstValueInAList($list, $res)
  {
    $head = f\head($list);

    $this->assertEquals($res, $head);
  }
}
