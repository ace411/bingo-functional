<?php

/**
 * _eio function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\IO\Internal;

use Chemem\Bingo\Functional\Functors\Monads\IO;
use Chemem\Bingo\Functional\Functors\Monads\Monad;

const _eio = __NAMESPACE__ . '\\_eio';

/**
 * _eio
 * returns object with which to perform non-blocking file reads and writes
 *
 * _eio :: Object
 *
 * @return Object
 */
function _eio()
{
  return new class () {
    private $fcontents = null;

    /**
     * read
     * performs the action of reading the contents of a specified file in a non-blocking fashion
     *
     * read :: String -> IO
     *
     * @param string $file
     * @return Monad
     */
    public function read(string $file): Monad
    {
      \eio_open(
        $file,
        EIO_O_RDONLY | EIO_O_NONBLOCK,
        EIO_S_IRUSR,
        EIO_PRI_DEFAULT,
        function (...$args) {
          [$file, $fd, $req] = $args;

          if ($fd > 0) {
            \eio_stat(
              $file,
              EIO_PRI_DEFAULT,
              function (...$args) {
                [$fd, $result] = $args;

                if (\key_exists('size', $result)) {
                  ['size' => $size] = $result;

                  // make subsequent file reads more performant
                  \eio_readahead(
                    $fd,
                    0,
                    $size,
                    EIO_PRI_DEFAULT,
                    function (...$args) use ($fd, $size) {
                      \eio_read(
                        $fd,
                        $size,
                        0,
                        EIO_PRI_DEFAULT,
                        function (...$args) use ($fd) {
                          [, $data]         = $args;
                          $this->fcontents  = IO\IO($data);

                          \eio_close($fd);
                        }
                      );
                    }
                  );
                }
              },
              $fd
            );
          } else {
            $this->fcontents = IO\IOException(
              \eio_get_last_error($req)
            );
          }
        },
        $file
      );
      \eio_event_loop();

      return $this->fcontents;
    }

    /**
     * write
     * performs the action of either writing or appending arbitrary data to a specified file in a non-blocking fashion
     *
     * write :: String -> String -> Bool -> IO
     *
     * @param string $file
     * @param string $data
     * @param bool $append
     * @return Monad
     */
    public function write(
      string $file,
      string $data,
      bool $append = false
    ): Monad {
      \eio_open(
        $file,
        (
          $append ?
            (
              EIO_O_NONBLOCK |
              EIO_O_WRONLY |
              EIO_O_APPEND |
              EIO_O_CREAT
            ) :
            (
              EIO_O_NONBLOCK |
              EIO_O_WRONLY |
              EIO_O_CREAT
            )
        ),
        EIO_S_IRUSR | EIO_S_IWUSR,
        EIO_PRI_DEFAULT,
        function (...$args) {
          [$params, $fd, $req]  = $args;
          [$contents, $append]  = $params;

          if ($fd > 0) {
            \eio_write(
              $fd,
              $contents,
              (
                \extension_loaded('mbstring') ?
                  'mb_strlen' :
                  'strlen'
              )($contents),
              0,
              EIO_PRI_DEFAULT,
              function (...$args) use ($fd) {
                [, $result] = $args;

                $this->fcontents = IO\IO($result);

                \eio_close($fd);
              }
            );
          } else {
            $this->fcontents = IO\IOException(
              \eio_get_last_error($req)
            );
          }
        },
        [$data, $append]
      );
      \eio_event_loop();

      return $this->fcontents;
    }
  };
}
