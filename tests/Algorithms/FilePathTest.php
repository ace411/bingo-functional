<?php

namespace Chemem\Bingo\Functional\Tests\Algorithms;

use Chemem\Bingo\Functional\Algorithms as f;

class FilePathTest extends \PHPUnit\Framework\TestCase
{
  public function contextProvider()
  {
    return [
      [0, ['foo', 'bar'], \dirname(__DIR__, 5) . '/foo/bar'],
      [1, ['foo/bar', 'baz'], \dirname(__DIR__, 6) . '/foo/bar/baz'],
    ];
  }

  /**
   * @dataProvider contextProvider
   */
  public function testfilePathPrintsAbsolutePathToFileOrDirectory($level, $frags, $res)
  {
    $path = f\filePath($level, ...$frags);

    $this->assertEquals($res, $path);
  }
}
