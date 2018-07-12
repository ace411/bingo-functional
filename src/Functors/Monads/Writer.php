<?php

/**
 * Writer monad.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Algorithms as A;

class Writer
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $logMsg;

    /**
     * Writer monad constructor.
     *
     * @param mixed  $value
     * @param string $logMsg
     */
    public function __construct($value, $logMsg)
    {
        $this->value = $value;
        $this->logMsg = $logMsg;
    }

    /**
     * of method.
     *
     * @static of
     *
     * @param mixed  $value
     * @param string $logMsg
     *
     * @return object Writer
     */
    public static function of($value, $logMsg) : self
    {
        return is_callable($value) ?
            new static(call_user_func($value), $logMsg) :
            new static($value, $logMsg);
    }

    /**
     * map method.
     *
     * @param callable $function The morphism used to transform the state value
     * @param string   $logMsg
     *
     * @return object Writer
     */
    public function map(callable $function, $logMsg) : self
    {
        return new static(
            call_user_func($function, $this->value),
            A\concat(PHP_EOL, $this->logMsg, $logMsg)
        );
    }

    /**
     * bind method.
     *
     * @param callable $function
     * @param string   $logMsg
     *
     * @return object Writer
     */
    public function bind(callable $function, $logMsg) : self
    {
        return $this->map($function, $logMsg);
    }

    /**
     * flatMap method.
     *
     * @param callable $function
     * @param string   $logMsg
     *
     * @return mixed $result
     */
    public function flatMap(callable $function, $logMsg)
    {
        return [
            call_user_func($function, $this->value),
            A\concat(PHP_EOL, $this->logMsg, $logMsg),
        ];
    }

    /**
     * run method.
     *
     * @return array [$value, $logMsg]
     */
    public function run()
    {
        return [$this->value, $this->logMsg];
    }
}
