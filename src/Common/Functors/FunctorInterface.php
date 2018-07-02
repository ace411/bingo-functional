<?php

/**
 * FunctorInterface design contract.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Common\Functors;

interface FunctorInterface
{
    /**
     * Map method.
     *
     * @param callable $fn
     *
     * @return object FunctorInterface
     */
    public function map(callable $fn) : self;
}
