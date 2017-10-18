<?php

/**
 * Error callbacks
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Common\Callbacks;

use InvalidArgumentException;
use Chemem\Bingo\Functional\Functors\Either\Left;
use Chemem\Bingo\Functional\Functors\Maybe\Nothing;

/**
 * extractErrorMessage function
 * extract an error message from Exception object
 *
 * @param Throwable $exception
 * @return string $message
 */

const extractErrorMessage = "Chemem\\Bingo\\Functional\\Callbacks\\extractErrorMessage";

function extractErrorMessage(\Throwable $exception) : string
{
    return '[Error]' .
        $exception->getMessage() .
        PHP_EOL .
        array_reduce(
            array_map(
                function ($traceItem, $traceEl) {
                    return '[' . $traceItem . ']' . $traceEl . PHP_EOL;
                },
                array_slice(
                    array_keys($exception->getTrace()[0]),
                    0,
                    3
                ),
                array_slice(
                    array_values($exception->getTrace()[0]),
                    0,
                    3
                )
            ),
            function ($carry, $val) : string {
                return $carry . $val;
            },
            ''
        );
}

/**
 * invalidArrayElement function
 * asserts that an array element is invalid
 *
 * @param $element
 * @return object InvalidArgumentException
 */

const invalidArrayElement = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\invalidArrayElement";

function invalidArrayElement($element) : InvalidArgumentException
{
    $elementType = gettype($element);

    switch ($elementType) {
        case 'array':
            $el = '[' . implode(',', $element) . ']';
            break;

        case 'object':
            $el = '[' .
                implode(
                    (new ReflectionMethod($element))
                        ->getParameters()
                ) .
                ']';
            break;

        default:
            $el = $element;
            break;
    }

    return new InvalidArgumentException(
        "The array element {$el} is invalid."
    );
}

/**
 * invalidArrayKey function
 * asserts that an array key is invalid
 *
 * @param mixed $key
 * @return object InvalidArgumentException
 */

const invalidArrayKey = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\invalidArrayKey";

function invalidArrayKey($key) : InvalidArgumentException
{
    return new InvalidArgumentException(
        "The key {$key} is invalid."
    );
}

const emptyArrayError = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\emptyArrayError";

function emptyArrayError() : InvalidArgumentException
{
    return new InvalidArgumentException(
        "The array is empty."
    );
}

/**
 * memoizationFailure function
 * asserts that a function cannot be memoized
 *
 * @param string $key
 * @param callable $fn
 * @return object InvalidArgumentException
 */

const memoizationFailure = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\memoizationFailure";

function memoizationFailure(string $key, callable $fn) : InvalidArgumentException
{
    $memFn = (new \ReflectionMethod($fn))
        ->getShortName();

    return new InvalidArgumentException(
        "The function {$memFn} cannot be bound to key {$key}"
    );
}

/**
 * leftValueException function
 * thrown when a Left value is returned
 *
 * @param Left $value
 * @return object InvalidArgumentException
 */

const leftValueException = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\leftValueException";

function leftValueException(Left $value) : InvalidArgumentException
{
    $value = $value instanceof Left ?
        $value->getLeft() :
        'Left value error.';

    $type = gettype($value);

    switch ($type) {
        case 'array':
            $val = '[' . implode(', ', $value) . ']';
            break;

        case 'object':
            $val = '[' .
                implode(
                    (new \ReflectionMethod($value))
                        ->getParameters()
                ) .
                ']';
            break;

        default:
            $val = $value;
    }

    return new InvalidArgumentException(
        "A left value {$val} has been returned"
    );
}

/**
 * nothingValueException function
 * thrown when a Nothing value is returned
 *
 * @param Nothing $value
 * @param callable $caller
 * @return object InvalidArgumentException
 */

const nothingValueException = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\nothingValueException";

function nothingValueException(Nothing $value, callable $caller) : InvalidArgumentException
{
    $value = $value instanceof Nothing &&
        $value->getNothing() === null ?
            'Nothing value found in ' :
            'Null value error in ';

    return new InvalidArgumentException(
        $value . $caller
    );
}

/**
 * valueFilterException function
 * thrown when a filter function returns a value other than the expected one
 *
 * @param callable $fn Filter function
 * @param mixed $value The value to be filtered
 * @return object InvalidArgumentException
 */

const valueFilterException = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\valueFilterException";

function valueFilterException(callable $fn, $value) : InvalidArgumentException
{
    $functionName = (new ReflectionFunction($fn))
        ->getShortName();

    return new InvalidArgumentException(
        'Function ' . $functionName . 'cannot be used to filter the value ' . $value
    );
}
