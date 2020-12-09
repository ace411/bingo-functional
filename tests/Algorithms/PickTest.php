<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class PickTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [(object) \range(1, 3), 2, 0],
      [['foo', 'bar', 'baz'], 'fooz', 'undefined'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testpickGetsSpecifiedListEntry($list, $val, $def)
  {
    $pick = f\pick($list, $val, $def);

    $this->assertTrue($pick == $val || $pick == $def);
  }
}
