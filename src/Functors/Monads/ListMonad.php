<?php

/**
 * List monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Algorithms as f;

class ListMonad implements Monadic
{
    const of = __CLASS__ . '::of';

    /**
     * list operation
     *
     * @var callable $listop
     */
    private $listop;

    public function __construct(callable $listop)
    {
        $this->listop = $listop;
    }

    /**
     * of method
     *
     * @param mixed $val
     * @return Monadic
     */
    public static function of($val): Monadic
    {
        return new static(function () use ($val) {
            return is_array($val) ? $val : [$val];
        });
    }

    /**
     * @inheritdoc
     */
    public function ap(Monadic $list): Monadic
    {
        return $list->map(...$this->extract());
    }

    /**
     * @inheritdoc
     */
    public function map(callable $function): Monadic
    {
        return new static(function () use ($function) {
            return f\mapDeep($function, $this->extract());
        });
    }

    /**
     * @inheritdoc
     */
    public function bind(callable $function): Monadic
    {
        return self::merge($function, $this->extract());
    }

    public function extract()
    {
        return ($this->listop)();
    }

    private static function merge(callable $function, $list)
    {
        $merge = f\compose(
            // transform every list entry in the list
            f\partial(f\fold, function ($acc, $val) use ($function) {
                $acc[] = $function($val)->extract();
                return $acc;
            }, $list),
            f\flatten
        );

        return new static(function () use ($merge) {
            return $merge([]);
        });
    }
}
