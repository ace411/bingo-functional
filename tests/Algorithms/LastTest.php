<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class LastTest extends \PHPunit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [\range(1, 20), 20],
      [(object) ['foo', 'bar'], 'bar'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testlastComputesTheFinalValueInAList($list, $res)
  {
    $head = f\last($list);

    $this->assertEquals($res, $head);
  }
}
