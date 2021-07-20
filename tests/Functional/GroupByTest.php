<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class GroupByTest extends \PHPunit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [
        [
          ['name' => 'butler', 'pos' => 'sg'],
          ['name' => 'robinson', 'pos' => 'sg'],
          ['name' => 'adebayo', 'pos' => 'c'],
        ],
        'pos',
        [
          'sg' => [
            ['name' => 'butler', 'pos' => 'sg'],
            ['name' => 'robinson', 'pos' => 'sg'],
          ],
          'c' => [
            ['name' => 'adebayo', 'pos' => 'c'],
          ],
        ],
      ],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testgroupBycreatesArraysGroupedByValueAssociatedWithSpecifiedKey($list, $key, $res)
  {
    $group = f\groupBy($list, $key);

    $this->assertEquals($res, $group);
  }
}
