<?php

/**
 * TransientMutator trait
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Common\Traits;

trait TransientMutator
{
    /**
     * @access private
     * @var bool $mutable
     */

    private $mutable = false;

    /**
     * isMutable method
     *
     * @return bool
     */

    public function isMutable() : bool
    {
        return $this->mutable;
    }

    /**
     * triggerMutation method
     *
     * @param callable $fn
     * @return object
     */

    public function triggerMutation(callable $fn)
    {
        $new = clone $this;
        $new->mutable = true;
        $new = call_user_func($fn, $new);
        $new->mutable = false;
        return $new;
    }
}
