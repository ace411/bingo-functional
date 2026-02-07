<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class WhereTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        [
          [
            'name'  => 'dwayne',
            'pos'   => 'sg'
          ],
          [
            'name'  => 'james',
            'pos'   => 'sf',
          ],
          [
            'name'  => 'demarcus',
            'pos'   => 'c',
          ],
        ],
        ['pos' => 'c'],
        [
          [
            'name'  => 'demarcus',
            'pos'   => 'c',
          ],
        ],
      ],
      [
        (object) [
          [
            'name'  => 'michael',
            'pos'   => 'sg'
          ],
          [
            'name'    => 'olajuwon',
            'pos'     => 'c',
            'co-star' => [
              'name'  => 'drexler',
              'pos'   => 'sg',
            ],
          ],
        ],
        ['name' => 'drexler'],
        [
          [
            'name'  => 'drexler',
            'pos'   => 'sg',
          ],
        ],
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
