<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class TailTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [(object) \range(1, 3), (object) [1 => 2, 2 => 3]],
      [['foo', 'bar'], [1 => 'bar']],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testtailReturnsEveryListItemButTheFirst($list, $res)
  {
    $tail = f\tail($list);

    $this->assertEquals($res, $tail);
  }
}
