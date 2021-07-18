<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class StartsWithTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      ['bingo-functional', 'bingo', true],
      ['chemem', 'mike', false],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testendsWithChecksIfStringEndsWithSpecifiedStringFragment($haystack, $needle, $res)
  {
    $check = f\startsWith($haystack, $needle);

    $this->assertEquals($res, $check);
  }
}
