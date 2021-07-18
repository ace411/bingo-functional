<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional as f;

class EndsWithTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      ['bingo-functional', 'functional', true],
      ['chemem', 'mike', false],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testendsWithChecksIfStringEndsWithSpecifiedStringFragment($haystack, $needle, $res)
  {
    $check = f\endsWith($haystack, $needle);

    $this->assertEquals($res, $check);
  }
}
