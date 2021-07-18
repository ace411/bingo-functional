<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class IdentityTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      ['foo'],
      [\range(1, 3)],
      [new \stdClass(3)],
      [12],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testidentityReturnsItsArgument($res)
  {
    $id = f\identity($res);

    $this->assertEquals($id, $res);
  }
}
