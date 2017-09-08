<?php

/**
 * CollectionApplicative functor
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicatives;

use Chemem\Bingo\Functional\Common\Applicatives\ApplicativeAbstract;
use Chemem\Bingo\Functional\Functors\Either\{Either, Left, Right};

class CollectionApplicative
    extends ApplicativeAbstract
    implements \IteratorAggregate
{
    /**
     * @access private
     * @var array $values
     */

    private $values;

    /**
     * CollectionApplicative constructor
     *
     * @param array $values
     */

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @inheritdoc
     */

    public static function pure($values) : ApplicativeAbstract
    {
        if ($values instanceof \Traversable) {
            $values = iterator_to_array($values);
        } elseif (!is_array($values)) {
            $values = [$values];
        }
        return new static($values);
    }

    /**
     * @inheritdoc
     */

    public function apply(ApplicativeAbstract $applicative) : ApplicativeAbstract
    {
        //ensure that all the values are functions
        $zipList = Either::right($this->values)
            ->filter(
                function ($arr) {
                    return array_filter(
                        $arr,
                        function ($val) {
                            return is_callable($val) ||
                                $val instanceof \Closure;
                        }
                    );
                },
                'Collection contains an invalid function'
            )
            ->map(
                function ($arr) use ($applicative) {
                    return array_reduce(
                        $arr,
                        function ($acc, $fn) use ($applicative) {
                            return array_merge(
                                $acc,
                                array_map($fn, $applicative->values)
                            );
                        },
                        []
                    );
                }
            );

        return $zipList->isRight() ?
            new static($zipList->getRight()) :
            new static($zipList->getLeft());
    }

    /**
     * getValues method
     *
     * @return array $values
     */

    public function getValues()
    {
        return $this->values;
    }

    /**
     * @inheritdoc
     *
     * @see ArrayIterator
     * @see IteratorAggregate
     * @return object ArrayIterator
     */

    public function getIterator()
    {
        return new ArrayIterator($this->getValues());
    }
}
