<?php

/**
 * Applicative and Monadic functor trait.
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Common\Applicatives;

use Chemem\Bingo\Functional\Functors\Applicatives\CollectionApplicative;
use Chemem\Bingo\Functional\Functors\Either\Either;
use Chemem\Bingo\Functional\Functors\Either\Right;

trait ApplicativeTrait
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * Constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Pure method.
     *
     * @param mixed $value
     *
     * @return object ApplicativeAbstract
     */
    public static function pure($value) : ApplicativeAbstract
    {
        return new static($value);
    }

    /**
     * Apply method.
     *
     * @param ApplicativeAbstract $applicative
     *
     * @return object ApplicativeAbstract
     */
    public function apply(ApplicativeAbstract $applicative) : ApplicativeAbstract
    {
        $applied = Either::right($this->getValue())
            ->filter(
                function ($val) {
                    return is_callable($val) ||
                        $val instanceof \Closure;
                },
                'Invalid Function'
            )
            ->map(
                function ($val) use ($applicative) {
                    return call_user_func(
                        $val,
                        $applicative instanceof CollectionApplicative ?
                            $applicative->getValues() :
                            $applicative->getValue()
                    );
                }
            );

        return $applied->isRight() ?
            new static($applied->getRight()) :
            new static($applied->getLeft());
    }

    /**
     * getValue method.
     *
     * @return mixed $value
     */
    public function getValue()
    {
        return $this->value;
    }
}
