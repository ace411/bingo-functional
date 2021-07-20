<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

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
