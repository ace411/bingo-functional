<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

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
