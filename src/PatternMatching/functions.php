<?php

/**
 * 
 * Pattern matching functions
 * 
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching;

use Chemem\Bingo\Functional\Algorithms as A;

/**
 * 
 * match function
 * 
 * @param array $options
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
 * 
 * getNumConditions function
 * 
 * @param array $conditions
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
 * 
 * patternMatch function
 * 
 * patternMatch :: [a, b] -> a -> (a())
 * 
 * @param array $patterns
 * @param mixed $value
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
 * 
 * evalArrayPattern function
 * 
 * evalArrayPattern :: [a, b] -> [a] -> (a())
 * 
 * @param array $patterns
 * @param array $value
 * @return mixed $result
 */

const evalArrayPattern = 'Chemem\\Bingo\\Functional\\PatternMatching\\evalArrayPattern';

function evalArrayPattern(array $patterns, array $comp)
{
    $evaluate = A\compose(
        'array_keys',
        function (array $pttnKeys) {
            $filter = A\partialLeft(A\filter, function ($pattern) {
                return substr($pattern, 0, 1) == '[' && substr($pattern, -1) == ']';
            });
            return $filter($pttnKeys);
        },
        function (array $pttnKeys) {
            $extract = A\compose(
                A\partialLeft('str_replace', '[', ''),
                A\partialLeft('str_replace', ']', ''),
                A\partialLeft('str_replace', ' ', ''),
                A\partialLeft('explode', ', '),
                function (array $tokens) {
                    return array_merge(...array_map(function ($token) {
                        return A\fold(function ($acc, $tkn) {
                            $acc[] = preg_match('/[\"]+/', $tkn) ? A\concat('*', '', str_replace('"', '', $tkn)) : $tkn;
                            return $acc;
                        }, explode(',', $token), []);
                    }, $tokens));
                }
            );
            return array_combine($pttnKeys, A\map($extract, $pttnKeys));
        },
        function (array $patterns) use ($comp) {
            $cmpCount = count($comp);
            $filter = A\partialRight('array_filter', function ($pttn) use ($cmpCount) {
                return count($pttn) == $cmpCount;
            });

            return $filter($patterns);
        },
        function (array $patterns) use ($comp) {
            $compLen = count($comp);

            $list = array_map(function ($pttns) use ($comp, $compLen) {
                $keys = array_map(function ($key) {
                    return str_replace('*', '', $key);
                }, $pttns);         

                $intersect = array_intersect_assoc($keys, $comp);
                return A\extend($pttns, ['intersect' => $intersect]);
            }, $patterns);

            return $list;
        },
        function (array $patterns) use ($comp) {
            return array_filter($patterns, function ($pttn) use ($comp) {
                $raw = A\dropRight(array_values($pttn), 1);
                $keys = array_map(function ($tkn) {
                    return str_replace('*', '', $tkn);
                }, $raw);

                return !empty($pttn['intersect']) && in_array('_', $keys) && end($keys) == end($comp) ||
                    !empty($pttn['intersect']) && !preg_match('/[\*\_]+/', end($raw)) ||
                    count($pttn['intersect']) == count($comp);
            });
        },
        function (array $pattern) use ($comp, $patterns) {
            $funcKey = !empty($pattern) ? A\head(array_keys($pattern)) : '_';
            $pttn = !empty($pattern) ? A\head($pattern) : [];
            $args = A\fold(function ($acc, $val) use ($comp, $pttn) {
                if (is_string($val) && !preg_match('/[\"\*]+/', $val)) {
                    $acc[] = $comp[A\indexOf($pttn, $val)];
                } 
                return $acc;
            }, $pttn, []);

            return !empty($args) ? $patterns[$funcKey](...$args) : $patterns[$funcKey]();
        }
    );

    return $evaluate($patterns);
}

/**
 * 
 * evalStringPattern function
 * 
 * evalStringPattern :: [a, b] -> a -> (a())
 *  
 * @param array $patterns
 * @param string $value
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
 * 
 * evalObjectPattern function
 * 
 * evalObjectPattern :: [a, b] -> b -> (b())
 * 
 * @param array $patterns
 * @param object $value
 * @return mixed $result  
 */

const evalObjectPattern = 'Chemem\\Bingo\\Functional\\PatternMatching\\evalObjectPattern';

function evalObjectPattern(array $patterns, $value)
{
    $valObj = get_class($value);

    $eval = A\compose(
        'array_keys',
        A\partialLeft(A\filter, function ($val) { return is_string($val) && preg_match("/([a-zA-Z]+)/", $val); }),
        A\partialLeft(A\filter, function ($classStr) use ($valObj) { return class_exists($classStr) && $classStr == $valObj; }),
        A\head,
        function (string $match) { return !empty($match) && !is_null($match) ? A\identity($match) : A\identity('_'); },
        function (string $key) use ($patterns) { 
            $func = $key == '_' ? isset($patterns['_']) ? A\identity($patterns['_']) : constantFunction(false) : A\identity($patterns[$key]);

            return call_user_func($func);
        }
    );

    return $eval($patterns);
}
