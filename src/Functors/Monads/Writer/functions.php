<?php

/**
 * Writer monad helpers.
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Writer-Lazy.html#g:2
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Writer;

use Chemem\Bingo\Functional as A;
use Chemem\Bingo\Functional\Functors\Monads\Monad;

const writer = __NAMESPACE__ . '\\writer';

/**
 * writer
 * Create a new instance of the writer monad.
 *
 * writer :: a -> w -> Writer (a, w)
 *
 * @param mixed $result
 * @param mixed $output
 * @return Writer
 */
function writer($result, $output = null): Monad
{
  return (__NAMESPACE__ . '::of')($result, $output);
}

const runWriter = __NAMESPACE__ . '\\runWriter';

/**
 * runWriter
 * Unwrap a writer computation as a (result, output) pair.
 *
 * runWriter :: Writer a w -> (a, w)
 *
 * @param Writer $writer
 * @return array
 */
function runWriter(Monad $writer): array
{
  return $writer->run();
}

const tell = __NAMESPACE__ . '\\tell';

/**
 * tell
 * A that produces a Writer monad's output
 *
 * tell :: w -> m ()
 *
 * @param mixed $msg
 * @return Writer
 */
function tell($msg): Monad
{
  $writer = __NAMESPACE__;

  return new $writer(function () use ($msg) {
    return [null, [$msg]];
  });
}

const execWriter = __NAMESPACE__ . '\\execWriter';

/**
 * execWriter
 * extracts the output from a writer computation.
 *
 * execWriter :: Writer a w -> w
 *
 * @param Writer $writer
 * @return array $output
 */
function execWriter(Monad $writer)
{
  [, $output] = $writer->run();

  return $output;
}

const mapWriter = __NAMESPACE__ . '\\mapWriter';

/**
 * mapWriter
 * maps both the return value and output of a computation using the given
 *
 * mapWriter :: ((a, w) -> (b, w')) -> Writer w a -> Writer w' b
 *
 * @param callable $function
 * @param Writer
 * @return Writer
 */
function mapWriter(callable $function, Monad $writer): Monad
{
  [$result, $output] = $function(runWriter($writer));

  return writer($result, $output);
}
