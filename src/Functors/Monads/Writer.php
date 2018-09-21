<?php

/**
 * Writer monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function \Chemem\Bingo\Functional\Algorithms\{concat, extend, flatten};

class Writer
{
    /**
     * @access private
     * @var mixed $result
     */
    private $result;

    /**
     * @access private
     * @var mixed $output
     */
    private $output = []; 

    /**
     * Writer monad constructor
     * 
     * @param mixed $result
     * @param mixed $output
     */
    public function __construct($result, $output)
    {
        $this->result = $result;
        $this->output[] = $output;
    }

    /**
     * of method.
     *
     * @static of
     * @param mixed $result
     * @param mixed $output
     * @return object Writer
     */

    public static function of($result, $output) : Writer
    {
        return new static($result, $output);
    }

    /**
     * ap method
     * 
     * @param Writer $app
     * @param mixed $output
     * @return object Writer
     */
    public function ap(Writer $app) : Writer
    {
        return $this->bind(function ($function) use ($app) {
            return $app->map($function);
        });
    }

    /**
     * map method.
     *
     * @param callable $function The morphism used to transform the state value
     * @param mixed $output
     * @return object Writer
     */

    public function map(callable $function) : Writer
    {
        return self::of($function($this->result), flatten($this->output));
    }

    /**
     * bind method.
     *
     * @param callable $function
     * @param mixed $output
     * @return object Writer
     */

    public function bind(callable $function) : Writer
    {
        list($result, $output) = $function($this->result)->run();

        return self::of($result, flatten(extend($this->output, $output)));
    }

    /**
     * flatMap method.
     *
     * @param callable $function
     * @param mixed $output
     * @return mixed $result
     */

    public function flatMap(callable $function) : array
    {
        return $this->map($function)->run();
    }

    /**
     * run method
     * 
     * @return array [$result, $output]
     */

    public function run() : array
    {
        return [$this->result, $this->output];
    }
}
