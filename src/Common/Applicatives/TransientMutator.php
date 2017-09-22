<?php

namespace Chemem\Bingo\Functional\Common\Applicatives;

trait TransientMutator
{
    private $mutable = false;

    public function isMutable() : bool
    {
        return $this->mutable;
    }

    public function triggerMutation(callable $fn)
    {
        $new = clone $this;
        $new->mutable = true;
        $new = call_user_func($fn, $new);
        $new->mutable = false;
        return $new;
    }
}
