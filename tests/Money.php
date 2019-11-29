<?php

declare(strict_types=1);

/**
 *
 * Demo value object to demonstrate Transient mutator usage
 * Adapted from an article written by Edd Mann
 *
 * @see https://tech.mybuilder.com/designing-immutable-concepts-with-transient-mutation-in-php/
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Tests;

use \Chemem\Bingo\Functional\{
  Algorithms as f,
  Common\Traits\TransientMutator as Transient
};

class Money
{
    use Transient;

    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function add(Money $money)
    {
        return $this->update($this->value + $money->value);
    }

    private function update($value)
    {
        if ($this->isMutable()) {
            $this->value = $value;
            return $this;
        }

        return new static($value);
    }
  
    public static function sum(...$monies)
    {
        return f\last($monies)->triggerMutation(function ($sum) use ($monies) {
            foreach ($monies as $money) {
                $sum->add($money);
            }

            return $sum;
        });
    }

    public function getWallet()
    {
        return $this->value;
    }
}
