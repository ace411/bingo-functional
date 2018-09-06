<?php

/**
 * Pattern matching functions.
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

use Chemem\Bingo\Functional\Algorithms as A;

/**
 * match function.
 *
 * @param array $options
 *
 * @return callable $matchCons
 */
const match = 'Chemem\\Bingo\\Functional\\PatternMatching\\match';

function match(array $options) : callable
{
    $matchFn = function (array $options) : array {
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
    $checkOpt = function (string $opt) : string {
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
    switch ($value) {
        case is_object($value):
            return evalObjectPattern($patterns, $value);
            break;

        case is_array($value):
            return evalArrayPattern($patterns, $value);
            break;

        default:
            return evalStringPattern($patterns, $value);
            break;
    }
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

function evalArrayPattern(array $patterns, array $value)
{
    $valCount = count($value);

    $evalPattern = A\compose(
        'array_keys',
        A\partialLeft(
            A\filter,
            function ($pattern) {
                return substr($pattern, -1) == ']' && substr($pattern, 0, 1) == '[';
            }),
        A\partialLeft(
            A\map,
            function ($pattern) {
                $tokens = A\compose(
                    A\partialLeft('str_replace', '[', ''),
                    A\partialLeft('str_replace', ']', ''),
                    A\partialLeft('str_replace', ' ', ''),
                    A\partialLeft('explode', ',')
                )($pattern);

                return [$pattern => $tokens];
            }
        ),
        function ($patterns) {
            return array_merge(...$patterns);
        },
        function ($patterns) use ($valCount) {
            return array_filter(
                $patterns,
                function ($pattern) use ($valCount) {
                    return count($pattern) == $valCount;
                }
            );
        },
        function ($patterns) use ($value) {
            $evaluate = A\compose(
                function ($patterns) {
                    return array_map(
                        function ($pattern) {
                            return array_map(function ($patt) {
                                return preg_match('/[\"]+/', $patt) ? str_replace('"', '', $patt) : null;
                            }, $pattern);
                        },
                        $patterns
                    );
                },

                function ($modified) use ($value, $patterns) {
                    $nonDoubleCount = function ($patterns, $count = 0) {
                        foreach ($patterns as $index => $value) {
                            foreach ($value as $subIndx => $subVal) {
                                $count += !preg_match('/[\"]+/', $subVal) ? 1 : 0;
                            }
                        }

                        return $count;
                    };

                    $nonDub = $nonDoubleCount($patterns);

                    return $nonDub == 0 ?
                        array_filter($modified, function ($val) use ($value) {
                            return $val == $value;
                        }) :
                        array_filter($modified, function ($val) use ($value, $nonDub) {
                            return A\dropRight($val, $nonDub) == A\dropRight($value, $nonDub);
                        });
                }
            );

            return $evaluate($patterns);
        },
        function ($modified) use ($patterns, $value, $valCount) {
            $modCount = count($modified);

            $nullCount = empty($modified) ?
                A\identity(0) :
                A\fold(
                    function ($acc, $val) {
                        $acc += is_null($val) ? 1 : 0;

                        return $acc;
                    },
                    A\head($modified),
                    0
                );

            switch ($modCount) {
                case 0:
                    return [
                        'func' => isset($patterns['_']) ? $patterns['_'] : A\constantFunction(false),
                        'args' => [],
                    ];
                    break;

                case 1:
                    return [
                        'func' => $patterns[A\head(array_keys($modified))],
                        'args' => $nullCount > 0 ? A\dropLeft($value, $valCount - $nullCount) : [],
                    ];
                    break;

                case $modCount > 1:
                    return [
                        'func' => $patterns[
                            A\head(
                                array_keys(
                                    array_filter(
                                        $modified,
                                        function ($pattern) use ($nullCount, $value) {
                                            return A\dropRight($pattern, $nullCount) == A\dropRight($value, $nullCount);
                                        }
                                    )
                                )
                            )
                        ],
                        'args' => A\dropLeft($value, $valCount - $nullCount),
                    ];
                    break;
            }
        }
    )($patterns);

    return call_user_func_array($evalPattern['func'], $evalPattern['args']);
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
                            $valType == 'double' ? (float) $val : $val;
                    },
                    function ($val) use ($value) {
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
