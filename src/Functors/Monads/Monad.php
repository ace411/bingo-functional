<?php

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Common\Applicatives\ApplicativeTrait;
use Chemem\Bingo\Functional\Common\Monads\MonadAbstract;

final class Monad extends MonadAbstract
{
    use ApplicativeTrait;

    public function bind(callable $fn) : MonadAbstract
    {
        return self::return($fn($this->getValue()));
    }

    public function filter(callable $fn) : MonadAbstract
    {
        return $fn($this->value) ? new static($this->value) : new static(null);
    }

    public function flatMap(callable $fn)
    {
        return $fn($this->getValue());
    }
}
