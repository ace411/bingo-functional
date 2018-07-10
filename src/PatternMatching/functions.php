<?php

namespace Chemem\Bingo\Functional\PatternMatching;

use Chemem\Bingo\Functional\Algorithms as A;

const match = 'Chemem\\Bingo\\Functional\\PatternMatching\\match';

function match(array $options) : callable
{
    $matchFn = function (array $options) : array {
        return array_key_exists('_', $options) ? 
            $options :
            ['_' => function () { return false; }];
    };

    $conditionGen = A\compose(
        $matchFn,
        A\partialRight('array_filter', function ($value) { return is_callable($value); }),
        'array_keys',
        getNumConditions
    );

    return function (array $values) use ($options, $matchFn, $conditionGen) {
        $valCount = count($values);

        $check = A\compose(
            $conditionGen,
            A\partialLeft(A\filter, function (int $count) use ($valCount) { return $count == $valCount; }),
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
                A\partialLeft(A\filter, function ($val) { return $val !== '_'; }),
                'count'
            );

            return [$condition => $opts($condition)];
        },
        $conditions
    );

    return array_merge(...$extr);
}

const patternMatch = 'Chemem\\Bingo\\Functional\\PatternMatching\\patternMatch';

function patternMatch(array $patterns, $value)
{
    $patternMatch = is_array($value) ? 
        evalArrayPattern($patterns, $value) :
        evalStringPattern($patterns, $value);

    return $patternMatch;
}

const evalArrayPattern = 'Chemem\\Bingo\\Functional\\PatternMatching\\evalArrayPattern';

function evalArrayPattern(array $patterns, array $value)
{
    $valCount = count($value);

    $evalPattern = A\compose(
        'array_keys',
        A\partialLeft(
            A\filter,
            function ($pattern) { return substr($pattern, -1) == ']' && substr($pattern, 0, 1) == '['; }),
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
        function ($patterns) { return array_merge(...$patterns); },
        function ($patterns) use ($valCount) {
            return array_filter(
                $patterns,
                function ($pattern) use ($valCount) { return count($pattern) == $valCount; }
            );
        },
        function ($patterns) use ($value, $valCount) {
            $evaluate = array_map(
                function ($pattern) use ($value, $valCount) {
                    return array_map(
                        function ($patternVal, $val) {
                            return preg_match('/[\"]+/', $patternVal) ? 
                                str_replace('"', '', $patternVal) == $val ? null : $val :
                                $val;
                        },
                        $pattern,
                        $value
                    );
                },
                $patterns
            );

            return $evaluate;
        },
        function ($patternArgs) {
            $evaluate = array_filter(
                $patternArgs,
                function ($pattArg) {
                    $argCount = count($pattArg);
                    $nullCountFn = function (int $init = 0, int $index) use (
                        $pattArg, 
                        $argCount, 
                        &$nullCountFn
                    ) {
                        if ($init >= $argCount) {
                            return $index;
                        }

                        $index += is_null($pattArg[$init]) ? 1 : 0;

                        return $nullCountFn($init + 1, $index);
                    };

                    $nullCount = $nullCountFn(0, 0);

                    return $nullCount == $argCount || $nullCount == $argCount - 1;
                }
            );

            return $evaluate;
        },
        function ($patternArgs) use ($patterns) {
            return !empty($patternArgs) ? 
                [
                    'function' => $patterns[A\head(array_keys($patternArgs))],
                    'arguments' => A\filter(
                        function ($arg) {
                            return !is_null($arg);
                        },
                        A\head($patternArgs)
                    ) 
                ] :
                [
                    'function' => isset($patterns['_']) ? $patterns['_'] : A\constantFunction(false),
                    'arguments' => []
                ];
        },
        function ($matches) use ($patterns) {
            $valType = A\compose('array_values', A\isArrayOf)($patterns);

            return $valType == 'object' ? 
                $matches : 
                [
                    'function' => A\constantFunction(false),
                    'arguments' => []
                ];
        }
    )($patterns);

    return call_user_func_array($evalPattern['function'], $evalPattern['arguments']);
}

const evalStringPattern = 'Chemem\\Bingo\\Functional\\PatternMatching\\evalStringPattern';

function evalStringPattern(array $patterns, string $value)
{
    $evalPattern = A\compose(
        'array_keys',
        A\partialLeft(A\filter, function ($val) { return is_string($val) && preg_match('/([\"]+)/', $val); }),
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
                    function ($val) use ($value) { return $val == $value ? A\concat('"', '', $val, '') : '_'; }
                );

                return $evaluate($val);
            }
        ),
        A\partialLeft(A\filter, function ($val) { return $val !== '_'; }),
        function ($match) { return !empty($match) ? A\head($match) : '_'; },
        function ($match) use ($patterns) {
            $valType = A\compose('array_values', A\isArrayOf)($patterns);

            return $valType == 'object' ? 
                $patterns[$match] : 
                ['_' => A\constantFunction(false)];
        }
    )($patterns);

    return call_user_func($evalPattern);
}