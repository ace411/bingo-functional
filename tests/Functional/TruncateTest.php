<?php

namespace Chemem\Bingo\Functional\Tests\Functional;

use Chemem\Bingo\Functional as f;

class TruncateTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      ['lorem ipsum', 5, 'lorem...'],
      ['MGS 5: The Phantom Pain', 3, 'MGS...'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testtruncateReturnsShortenedStringWithEllipsisAttached($str, $limit, $res)
  {
    $truncated = f\truncate($str, $limit);

    $this->assertEquals($res, $truncated);
  }
}
