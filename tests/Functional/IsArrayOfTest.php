<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class IsArrayOfTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [\range(1, 3), 'integer'],
      [['foo', 'bar'], 'string'],
      [[[2], ['foo']], 'array'],
      [[1.2, 3.2], 'double'],
      [[3, 'foo', new \stdClass(2)], 'mixed'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testisArrayOfComputesArrayType($list, $res)
  {
    $type = f\isArrayOf($list);

    $this->assertEquals($res, $type);
  }
}
