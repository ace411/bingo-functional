<?php

/**
 * Writer monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\Algorithms\extend;

class Writer implements Monadic
{
    const of = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Writer::of';

    /**
     * @var callable action
     */
     private $action;

    public function __construct(callable $action)
    {
        $this->action = $action;
    }

    /**
     * of method.
     *
     * @static of
     *
     * @param mixed $result
     * @param mixed $output
     *
     * @return object Writer
     */
    public static function of($result, $output) : self
    {
        return new static(function () use ($result, $output) {
            return [$result, [$output]];
        });
    }

    /**
     * ap method.
     *
     * @param Writer $app
     * @param mixed  $output
     *
     * @return object Writer
     */
    public function ap(Monadic $app) : Monadic
    {
        return $this->bind(function ($function) use ($app) {
            return $app->map($function);
        });
    }

    /**
     * map method.
     *
     * @param callable $function The morphism used to transform the state value
     * @param mixed    $output
     *
     * @return object Writer
     */
    public function map(callable $function) : Monadic
    {
        return new static(function () use ($function) {
            list($result, $output) = $this->run();

            return [$function($result), $output];
        });
    }

    /**
     * bind method.
     *
     * @param callable $function
     * @param mixed    $output
     *
     * @return object Writer
     */
    public function bind(callable $function) : Monadic
    {
        return new static(function () use ($function) {
            list($result, $output)  = $this->run();
            list($res, $out)        = $function($result)->run();

            return [$res, extend($output, $out)];
        });
    }

    /**
     * flatMap method.
     *
     * @param callable $function
     * @param mixed    $output
     *
     * @return mixed $result
     */
    public function flatMap(callable $function) : array
    {
        return $this->map($function)->run();
    }

    /**
     * run method.
     *
     * @return array [$result, $output]
     */
    public function run() : array
    {
        return call_user_func($this->action);
    }
}
