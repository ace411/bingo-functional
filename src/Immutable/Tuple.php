<?php

declare(strict_types=1);

/**
 * Immutable Tuple class
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

class Tuple implements \Countable, ImmutableDataStructure
{
    use CommonTrait;

    /**
         * fst method
         *
         * fst :: (a, b) -> a
         * @see https://hackage.haskell.org/package/base-4.12.0.0/docs/Data-Tuple.html
         * @return mixed
         */
    

    public function fst()
    {
        return $this->fetchFromPair(0);
    }

    /**
     * snd method
     *
     * snd :: (a, b) -> b
     * @see https://hackage.haskell.org/package/base-4.12.0.0/docs/Data-Tuple.html
     * @return mixed
     */
    public function snd()
    {
        return $this->fetchFromPair(1);
    }

    /**
     * swap method
     *
     * swap :: (a, b) -> (b, a)
     * @see https://hackage.haskell.org/package/base-4.12.0.0/docs/Data-Tuple.html
     * @return Tuple
     */
    public function swap(): Tuple
    {
        if ($this->count() != 2) {
            throw new TupleException(TupleException::PAIR_ERRMSG);
        }

        return self::from([$this->snd(), $this->fst()]);
    }

    /**
     * get method
     *
     * @param int $index
     * @return mixed
     */
    public function get(int $index)
    {
        return $this->offsetGet($index);
    }

    /**
     * fetchFromPair method
     *
     * fetchFromPair :: Int -> a
     *
     * @param int $index
     * @return mixed
     */
    private function fetchFromPair(int $index)
    {
        if ($this->count() !== 2) {
            throw new TupleException(TupleException::PAIR_ERRMSG);
        }
            
        return $this->get($index);
    }
}
