<?php

/**
 * Applicative functor
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicatives;

use \FunctionalPHP\FantasyLand\{Apply, Functor, Pointed};

class Applicative implements Pointed, Apply
{
    /**
     * @var mixed $value
     * @access private
     */
    private $value;

    /**
     * constructor
     * 
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * pure method
     * 
     * @static
     * @param mixed $value
     * @return object Applicative
     */
    public static function pure($value)
    {
        return new static($value);
    }

     /**
     * of method
     * 
     * @inheritdoc
     */
    public static function of($value)
    {
        return new static($value);
    }
    
    /**
     * ap method
     * 
     * @inheritdoc
     */
    public function ap(Apply $app) : Apply
    {
        return new static($this->getValue()($app->getValue()));
    }

    /**
     * map method
     * 
     * @inheritdoc
     */
    public function map(callable $function) : Functor
    {
        return self::pure($function)->ap($this);
    }

    /**
     * getValue method
     * 
     * @return mixed $value
     */
    public function getValue()
    {
        return $this->value;
    }
}
