<?php

declare(strict_types=1);

/**
 * ImmutableDataStructure interface
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Immutable;

interface ImmutableDataStructure
{
    /**
     * from static method.
     *
     * @method from
     *
     * @param mixed $array
     *
     * @return ImmutableDataStructure
     */
    public static function from(array $list): ImmutableDataStructure;
/**
     * contains method
     *
     * @method contains
     *
     * @param mixed element
     *
     * @return bool
     */
    public function contains($element): bool;
/**
     * head method
     *
     * @method head
     * @see https://ace411.github.io/bingo-functional/#/collection?id=head-function
     *
     * @return mixed
     */
    public function head();
/**
     * tail method
     *
     * @method tail
     * @see https://ace411.github.io/bingo-functional/#/collection?id=tail-function
     *
     * @return ImmutableDataStructure
     */
    public function tail(): ImmutableDataStructure;
/**
     * last method
     *
     * @method last
     * @see https://ace411.github.io/bingo-functional/#/collection?id=last-function
     *
     * @return mixed
     */
    public function last();
}
