<?php

declare(strict_types=1);

/**
 * TupleException class
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

class TupleException extends \Exception
{
  public const PAIR_ERRMSG = 'Sorry, this method is only available for tuple pairs';
}
