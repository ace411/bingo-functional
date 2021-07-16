<?php

/**
 * TransientMutator trait.
 * Adapted from an article written by Edd Man
 *
 * @see https://tech.mybuilder.com/designing-immutable-concepts-with-transient-mutation-in-php/
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Common\Traits;

trait TransientMutator
{
  /**
   * @property bool $mutable Mutability flag to condition mutation
   */
  private $mutable = false;

  /**
   * isMutable
   * checks if object state is mutable
   *
   * isMutable :: Object => o a -> Bool
   *
   * @return bool
   */
  public function isMutable(): bool
  {
    return $this->mutable;
  }

  /**
   * triggerMutation
   * performs mutation of internal object state
   *
   * triggerMutation :: Object => o a -> (a -> b) -> o b
   *
   * @param callable $fn
   * @return object
   */
  public function triggerMutation(callable $fn)
  {
    $new          = clone $this;
    $new->mutable = true;
    $new          = $fn($new);
    $new->mutable = false;

    return $new;
  }
}
