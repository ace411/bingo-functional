<?php

/**
 * Applicative functor
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicatives;

use Chemem\Bingo\Functional\Common\Applicatives\{ApplicativeTrait, ApplicativeAbstract};
use Chemem\Bingo\Functional\Functors\Maybe\{Maybe, Just, Nothing};

final class Applicative extends ApplicativeAbstract
{
    /**
     * @see ApplicativeTrait
     */

    use ApplicativeTrait;
}
