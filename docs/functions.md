---
title: function-helpers
subTitle: Documentation for helper functions used on functions
---

## Composing functions

```
compose(callable ...$functions)
```

The ability to combine functions is a concept borrowed from mathematics. Simply put, composition is applying a function to the output of another function thereby transforming it. A function f and another function g can be 'composed' to create a function f o g.

**Since:** v1.0.0

**Arguments:**

- ***functions (callable)*** - The functions to chain

```php
use Chemem\Bingo\Functional\Algorithms as A;

$composed = A\compose(
    function (int $a) : int {
        return $a + 10;
    },
    function (int $a) : int {
        return $a * 10;
    }
); //could be any callable value(s)

$output = array_map($composed, [1, 2, 3]);
//should return [110, 120, 130]
```  

## Partial application

```
partial(callable $function, mixed ...$args)(mixed ...$args)
```

If the intention is to supply parameters to a function incrementally, partial application is a possible solution. At the core of partial application is binding arguments to a function.

**Since:** 1.0.0, excluded from versions 1.2.0 to 1.7.2

**Arguments:**

- ***function (callable)*** - The function to which arguments are partially applied
- ***args (mixed)*** - The arguments to bind to the function

```php

$partial = A\partial(
    function (int $a, int $b) : int {
        return $a + $b;
    },
    1
); //bind the argument 1 to the function

$partial(2); //bind 2 to the function; should return 3
```

### Partial-Left

```
partialLeft(callable $function, mixed ...$args)(mixed ...$args)
```

**Since:** v1.2.0

**Arguments:**

- ***function (callable)*** - The function to which arguments are partially applied
- ***args (mixed)*** - The arguments to bind to the function

Works just like the partial function. Arguments are, with the partialLeft function, incrementally supplied from left to right.

```php
$partialLeft = A\partialLeft(
    function (int $a, int $b) : int {
        return $a - $b;
    },
    12
);

$partialLeft(9); //should output 3
```

### Partial-Right

```
partialRight(callable $function, mixed ...$args)(mixed ...$args)
```

**Since:** v1.2.0

**Arguments:**

- ***function (callable)*** - The function to which arguments are partially applied
- ***args (mixed)*** - The arguments to bind to the function

This is the antipode of the partialLeft function. The argument order is right to left.

```php
$partialRight = A\partialRight(
    function (int $a, int $b) : int {
        return $a - $b;
    },
    9
);

$partialRight(12); //outputs 3
```

## Currying

```
curry(callable $function)
```

**Since:** v1.0.0

**Arguments:**

- ***function (callable)*** - The function to curry

Related to partial application is currying which is premised on splitting a higher-order function into smaller functions each taking a single argument. The idea of binding arguments to a function incrementally features strongly here as well.

```php

$curryied = A\curry(
    function (int $a, int $b) : int {
        return $a * $b;
    }
);

$curryied(4)(5); //should return 20
```

## CurryN

```
curryN(int $paramCount, callable $function)
```

**Since:** v1.0.0

**Arguments:**

- ***paramCount (int)*** - The number of parameters to curry
- ***function (callable)*** - The function to curry

The curryN function allows for specifying the number of parameters to curry. This can be used for functions with default/optional parameters.

```php

$curryied = A\curryN(
    2,
    function (int $a, int $b, int $c = null) : int {
        return $a + $b + $c;
    }
);

$curryied(2)(3); //should return 5
```

## Identity

```
identity(mixed $value)
```

**Since:** v1.0.0

**Arguments:**

- ***value (mixed)*** - An arbitrary value

Central to the identity law of functors is the identity function. This function is pretty straightforward; it returns the value it receives with no transformations whatsoever.

```php

$id = A\identity('foo');
//should return foo
```

## Constant function

```
constantFunction(mixed $value)
```

**Since:** v1.0.0

**Arguments:**

- ***value (mixed)*** - An arbitrary value

The constant function is one that always returns the first argument it receives.

```php

$const = A\constantFunction(1);
$const(); //should return 1
```

## Throttle function

```
throttle(callable $function, int $time)(mixed ...$args)
```

**Since:** v1.4.0

**Arguments:**

- ***function (callable)*** - The function to throttle
- ***time (int)*** - The throttle time
- ***args (mixed)*** - The function arguments

The throttle function is used to defer function processing.

```php
$addTwelve = function (int $val) : int {
    return $val + 12;
};

$throttle = A\throttle($addTwelve, 10);

echo $throttle(0);
//prints the digit 12 after 10 seconds
```

**Note:** The throttle function as of v1.7.1 supports functions with multiple arguments.

## Memoize function

```
memoize(callable $function)
```

**Since:** v1.0.0

**Arguments:**

- ***function (callable)*** - The function to memoize

Sometimes, a computation might be expensive. Memoization ensures that the output of a computed result is cached and conveyed.

```php
$factorial = A\memoize(
    function (int $num) use (&$factorial) {
        return $num < 2 ? 1 : $factorial($num - 1) * $num;
    }
);

$factorial(130); //outputs float(6.4668554892205E+219)
```

## Callback signatures

**Note:** Callbacks will not be usable beyond bingo-functional v1.7.2. Check out the [changelog](https://ace411.github.io/bingo-functional/changes).

These are essential for proper functioning of the the following helper functions: ```pluck()```, ```pick()```, ```memoize()```, as well as ```isArrayOf()```. The following callback signatures correspond to the functions listed:

- ```invalidArrayKey :: key -> errMsg```

- ```invalidArrayValue :: key -> errMsg```

- ```memoizationError :: Callable fn -> errMsg```

- ```emptyArray :: Nothing -> errMsg``` 

**Note:** You can write your own callbacks provided they adhere to the signatures listed above.