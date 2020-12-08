<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class ToWordsTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      ['foo-bar:baz', '/([-:])+/', ['foo', 'bar', 'baz']],
      ['http://foo.com/bar', '/([:\/])+/', ['http', 'foo.com', 'bar']]
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testtoWordsTransformsStringIntoArrayOfWords($str, $regex, $res)
  {
    $words = f\toWords($str, $regex);

    $this->assertEquals($res, $words);
  }
}
