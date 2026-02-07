<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class ListFromPathsTest extends \PHPUnit\Framework\TestCase
{
  public static function contextProvider()
  {
    return [
      [
        [
          [
            'foo.bar' => 12,
            'foo.qux' => 'foo'
          ]
        ],
        [
          'foo'   => [
            'bar' => 12,
            'qux' => 'foo'
          ]
        ]
      ],
      [
        [
          [
            'foo:bar' => 12,
            'foo:qux' => 'foo'
          ]
        ],
        [
          'foo:bar' => 12,
          'foo:qux' => 'foo'
        ]
      ],
      [
        [
          (object) [
            'foo.bar'   => 12,
            'foo.qux.0' => 'foo',
            'foo.qux.2' => 'baz',
            'quux'      => \range(1, 3)
          ]
        ],
        [
          'foo'   => [
            'bar' => 12,
            'qux' => [
              0   => 'foo',
              2   => 'baz'
            ]
          ],
          'quux'  => \range(1, 3)
        ]
      ],
      [
        [\range(1, 3)],
        \range(1, 3)
      ],
      [
        [
          (object) [
            'foo.bar'   => 12,
            'foo.qux.0' => 'foo',
            'foo.qux.2' => 'baz',
            'quux'      => \range(1, 3)
          ],
          ':'
        ],
        [
          'foo.bar'   => 12,
          'foo.qux.0' => 'foo',
          'foo.qux.2' => 'baz',
          'quux'      => \range(1, 3)
        ]
      ],
      [
        [
          [
            'foo->bar'    => 12,
            'foo->qux->0' => 'foo',
            'foo->qux->2' => 'baz',
            'quux'        => \range(1, 3),
          ],
          '->'
        ],
        [
          'foo'   => [
            'bar' => 12,
            'qux' => [
              0   => 'foo',
              2   => 'baz'
            ],
          ],
          'quux'  => \range(1, 3),
        ]
      ]
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testlistFromPathsCreatesListFromAnotherListThatContainsPathsAndTheValuesAssociatedWithThem(array $args, $result)
  {
    $list = f\listFromPaths(...$args);

    $this->assertEquals($result, $list);
  }
}
