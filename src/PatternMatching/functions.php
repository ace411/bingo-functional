<?php

namespace Chemem\Bingo\Functional\PatternMatching;

use Chemem\Bingo\Functional\Algorithms as A;

const match = 'Chemem\\Bingo\\Functional\\PatternMatching\\match';

function match(array $options) : callable
{
    $matchFn = function (array $options) : array {
        return array_key_exists('_', $options) ? 
            $options :
            [
                '_' => function () {
                    return false;
                }
            ];
    };

    $conditionGen = A\compose(
        $matchFn,
        A\partialRight(
            'array_filter',
            function ($value) {
                return is_callable($value);
            }
        ),
        'array_keys',
        getNumConditions
    );

    return function (array $values) use ($options, $matchFn, $conditionGen) {
        $valCount = count($values);

        $check = A\compose(
            $conditionGen,
            A\partialLeft(
                A\filter,
                function (int $count) use ($valCount) {
                    return $count == $valCount;
                }
            ),
            A\head
        );

        return $check($options) > 0 ? 
            call_user_func_array(
                $options[A\indexOf($conditionGen($options), $valCount)],
                $values
            ) :
            call_user_func($matchFn($options)['_']);
    };
}

const getNumConditions = 'Chemem\\Bingo\\Functional\\PatternMatching\\getNumConditions';

function getNumConditions(array $conditions)
{
    $checkOpt = function (string $opt) : string {
        return preg_match('/([_])+/', $opt) ? $opt : '_';
    };

    $extr = A\map(
        function (string $condition) use ($checkOpt) {
            $opts = A\compose(
                $checkOpt,
                A\partialLeft('preg_replace', '/([(\)])+/', ''),
                A\partialLeft('explode', ':'),
                A\partialLeft(
                    A\filter, 
                    function ($val) {
                        return $val !== '_';
                    }
                ),
                'count'
            );

            return [$condition => $opts($condition)];
        },
        $conditions
    );

    return array_merge(...$extr);
}