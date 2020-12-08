<?php

namespace Chemem\Bingo\Functional\Tests\Transient;

use Chemem\Bingo\Functional\{
  Algorithms as f,
  Common\Traits\TransientMutator as Transient,
};

class Money
{
  use Transient;

  private $value;

  public function __construct(float $value)
  {
    $this->value = $value;
  }

  public function getWallet()
  {
    return $this->value;
  }

  public static function sum(Money ...$monies)
  {
    return f\last($monies)->triggerMutation(function ($sum) use ($monies) {
      foreach ($monies as $money) {
        $sum->add($money);
      }

      return $sum;
    });
  }

  public function add(Money $money)
  {
    return $this->update($this->value + $money->getWallet());
  } 

  private function update(float $value)
  {
    if ($this->isMutable()) {
      $this->value = $value;
      return $this;
    }

    return new static($value);
  }
}
