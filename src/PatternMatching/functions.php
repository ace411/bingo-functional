<?php

/**
 * Pattern matching functions.
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

use Chemem\Bingo\Functional\Algorithms as A;
use Chemem\Bingo\Functional\Functors\Maybe;
use FunctionalPHP\PatternMatching as p;

/**
 * match function.
 *
 * @param array $options
 *
 * @return callable $matchCons
 */

const match = 'Chemem\\Bingo\\Functional\\PatternMatching\\match';

function match(array $options): callable
{
    $matchFn = function (array $options): array {
        return array_key_exists('_', $options) ?
            $options :
            ['_' => function () {
                return false;
            }];
    };

    $conditionGen = A\compose(
        $matchFn,
        A\partialRight('array_filter', function ($value) {
            return is_callable($value);
        }),
        'array_keys',
        getNumConditions
    );

    return function (array $values) use ($options, $matchFn, $conditionGen) {
        $valCount = count($values);

        $check = A\compose(
            $conditionGen,
            A\partialLeft(A\filter, function (int $count) use ($valCount) {
                return $count == $valCount;
            }),
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

/**
 * getNumConditions function.
 *
 * @param array $conditions
 *
 * @return array $matches
 */
const getNumConditions = 'Chemem\\Bingo\\Functional\\PatternMatching\\getNumConditions';

function getNumConditions(array $conditions)
{
    $checkOpt = function (string $opt): string {
        return preg_match('/([_])+/', $opt) ? $opt : '_';
    };

    $extr = A\map(
        function (string $condition) use ($checkOpt) {
            $opts = A\compose(
                $checkOpt,
                A\partialLeft('preg_replace', '/([(\)])+/', ''),
                A\partialLeft('explode', ':'),
                A\partialLeft(A\filter, function ($val) {
                    return $val !== '_';
                }),
                'count'
            );

            return [$condition => $opts($condition)];
        },
        $conditions
    );

    return array_merge(...$extr);
}

/**
 * patternMatch function.
 *
 * patternMatch :: [a, b] -> a -> (a())
 *
 * @param array $patterns
 * @param mixed $value
 *
 * @return mixed $result
 */
const patternMatch = 'Chemem\\Bingo\\Functional\\PatternMatching\\patternMatch';

function patternMatch(array $patterns, $value)
{
    $matches = Maybe\Maybe::just($value)
        ->filter(function ($value) {
            return !empty($value) || !isset($value);
        });

    return Maybe\maybe(
        key_exists('_', $patterns) ? ($patterns['_'])() : false,
        function ($value) use ($patterns) {
            switch ($value) {
                case is_object($value):
                    return evalObjectPattern($patterns, $value);
                    break;

                case is_array($value):
                    return evalArrayPattern($patterns, $value);
                    break;

                case is_string($value):
                    return evalStringPattern($patterns, $value);
                    break;
            }
        },
        $matches
    );
}

/**
 * evalArrayPattern function.
 *
 * evalArrayPattern :: [a, b] -> [a] -> (a())
 *
 * @param array $patterns
 * @param array $value
 *
 * @return mixed $result
 */
const evalArrayPattern = 'Chemem\\Bingo\\Functional\\PatternMatching\\evalArrayPattern';

function evalArrayPattern(array $patterns, array $comp)
{
    return p\match($patterns, $comp);
}

/**
 * evalStringPattern function.
 *
 * evalStringPattern :: [a, b] -> a -> (a())
 *
 * @param array  $patterns
 * @param string $value
 *
 * @return mixed $result
 */
const evalStringPattern = 'Chemem\\Bingo\\Functional\\PatternMatching\\evalStringPattern';

function evalStringPattern(array $patterns, string $value)
{
    $evalPattern = A\compose(
        'array_keys',
        A\partialLeft(A\filter, function ($val) {
            return is_string($val) && preg_match('/([\"]+)/', $val);
        }),
        A\partialLeft(
            A\map,
            function ($val) use ($value) {
                $evaluate = A\compose(
                    A\partialLeft('str_replace', '"', ''),
                    function ($val) {
                        $valType = gettype($val);

                        return $valType == 'integer' ?
                            (int) $val :
                            ($valType == 'double' ? (float) $val : $val);
                    },
                    function ($val) use ($value) {
                        if (empty($value)) {
                            return '_';
                        }
                        
                        return $val == $value ? A\concat('"', '', $val, '') : '_';
                    }
                );

                return $evaluate($val);
            }
        ),
        A\partialLeft(A\filter, function ($val) {
            return $val !== '_';
        }),
        function ($match) {
            return !empty($match) ? A\head($match) : '_';
        },
        function ($match) use ($patterns) {
            $valType = A\compose('array_values', A\isArrayOf)($patterns);

            return $valType == 'object' ?
                $patterns[$match] :
                ['_' => A\constantFunction(false)];
        }
    )($patterns);

    return call_user_func($evalPattern);
}

/**
 * evalObjectPattern function.
 *
 * evalObjectPattern :: [a, b] -> b -> (b())
 *
 * @param array  $patterns
 * @param object $value
 *
 * @return mixed $result
 */
const evalObjectPattern = 'Chemem\\Bingo\\Functional\\PatternMatching\\evalObjectPattern';

function evalObjectPattern(array $patterns, $value)
{
    $valObj = get_class($value);

    $eval = A\compose(
        'array_keys',
        A\partialLeft(A\filter, function ($val) {
            return is_string($val) && preg_match('/([a-zA-Z]+)/', $val);
        }),
        A\partialLeft(A\filter, function ($classStr) use ($valObj) {
            return class_exists($classStr) && $classStr == $valObj;
        }),
        A\head,
        function (string $match) {
            return !empty($match) && !is_null($match) ? A\identity($match) : A\identity('_');
        },
        function (string $key) use ($patterns) {
            $func = $key == '_' ? isset($patterns['_']) ? A\identity($patterns['_']) : constantFunction(false) : A\identity($patterns[$key]);

            return call_user_func($func);
        }
    );

    return $eval($patterns);
}

/**
 *
 * letIn function
 *
 * letIn :: String -> [a, b] -> (Array -> ((a, b) -> c)) -> c
 *
 * @param array $params
 * @param array $list
 * @return callable
 */

const letIn = 'Chemem\\Bingo\\Functional\\PatternMatching\\letIn';

function letIn(string $pattern, array $items): callable
{
    // extract the tokens from the list
    $tokens = p\extract($pattern, $items);

    return function (array $keys, callable $func) use ($tokens) {
        // match keys against extracted tokens
        $args = A\fold(function (array $acc, string $key) use ($tokens) {
            if (isset($tokens[$key])) {
                $acc[] = $tokens[$key];
            }

            return $acc;
        }, $keys, []);

        return $func(...$args);
    };
}
