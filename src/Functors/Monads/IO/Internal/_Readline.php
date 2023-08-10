<?php

/**
 * _readline
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO\Internal;

use Chemem\Bingo\Functional\Functors\Monads\IO;
use Chemem\Bingo\Functional\Functors\Monads\Monad;

const _readline = __NAMESPACE__ . '\\_readline';

/**
 * _readline function
 * powered by ext-readline, the function reads string or character data from standard input device
 *
 * _readline :: String -> (String -> Bool) -> IO
 *
 * @internal
 * @param string $str
 * @param callable $handler
 * @return IO
 */
function _readline($str = null, callable $handler = null): Monad
{
  return IO::of(
    !\is_null($handler) ?
      function () use ($handler, $str) {
        \readline_callback_handler_install(
          \is_null($str) ? '' : $str,
          $handler
        );
        \readline_callback_read_char();

        return \readline_info('line_buffer');
      } :
      function () use ($str) {
        return \readline($str);
      }
  );
}
