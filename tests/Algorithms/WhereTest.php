<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class WhereTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        [
          ['name' => 'dwayne', 'pos' => 'sg'],
          ['name' => 'james', 'pos' => 'sf'],
          ['name' => 'demarcus', 'pos' => 'c'],
        ],
        ['pos' => 'c'],
        [['name' => 'demarcus', 'pos' => 'c']],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testwhereSearchesArrayForSpecifiedKeyValuePair($list, $search, $res)
  {
    $result = f\where($list, $search);

    $this->assertEquals($res, $result);
  }
}
