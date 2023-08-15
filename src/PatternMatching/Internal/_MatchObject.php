<?php

namespace Chemem\Bingo\Functional\PatternMatching\Internal;

require_once __DIR__ . '/_ExecTypeMatch.php';

use function Chemem\Bingo\Functional\equals;

const _matchObject = __NAMESPACE__ . '\\_matchObject';

function _matchObject(array $patterns, $input)
{
  return _execTypeMatch(
    $patterns,
    $input,
    function ($input, $pattern) {
      return equals(\get_class($input), $pattern);
    }
  );
}
