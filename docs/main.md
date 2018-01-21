# bingo-functional documentation

The bingo-functional library is a functional programming library built in PHP for PHP users. Available in this library are monads, Just/Nothing types, Left/Right types, applicative functors, and function algorithms meant to ease the cognitive burden for those who intend to use them. The subsequent text is documentation of the library which should help you, the reader, understand how to go about using it.

## Installation

Before you can use the bingo-functional library, you should have either Git or Composer installed on your system of preference. To install the package via Composer, type the following in your preferred command line interface:

```composer require chemem/bingo-functional```

To install via Git, type:

```git clone https://github.com/ace411/bingo-functional.git```

## Algorithms

### Composing functions

The ability to combine functions is a concept borrowed from mathematics. Simply put, composition is applying a function to the output of another function thereby transforming it. A function f and another function g can be 'composed' to create a function f o g.

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

### Partial application

If the intention is to supply parameters to a function incrementally, partial application is a possible solution. At the core of partial application is binding arguments to a function.

```php

$partial = A\partial(
    function (int $a, int $b) : int {
        return $a + $b;
    },
    1
); //bind the argument 1 to the function

$partial(2); //bind 2 to the function; should return 3
```

### Currying

Related to partial application is currying which is premised on splitting a higher-order function into smaller functions each taking a single argument. The idea of binding arguments to a function incrementally features strongly here as well.

```php

$curryied = A\curry(
    function (int $a, int $b) : int {
        return $a * $b;
    }
);

$curryied(4)(5); //should return 20
```

#### CurryN

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

### Picking

Picking is a means of selecting an item from a list. This list, is, usually an array.

```php
use Chemem\Bingo\Functional\Common\Callbacks as CB;

$list = ['Spurs', 'Rockets', 'Heat', 'Pelicans'];

$picked = A\pick($list, 'Heat', CB\invalidArrayValue); //modified to accept a callback parameter
//returns 'Heat'
```

### Plucking

Like picking, plucking is a means of selecting an item from a list. The difference is in the means of selection. Plucking selects an item by index.

```php
use Chemem\Bingo\Functional\Common\Callbacks as CB;

$list = ['PG' => 'Dragic', 'SG' => 'Reddick', 'SF' => 'Durant'];

$plucked = A\pluck($list, 'SF', CB\invalidArrayKey); //also modified to accept a callback parameter
//returns 'Durant'
```

### Zipping

Also used to manipulate lists is zipping. A zipped array is a multidimensional array of grouped arrays. It can be created either via function binding or array key combination.

```php

$pos = ['PG', 'SG', 'SF'];
$players = ['Dragic', 'Reddick', 'Durant'];

$zippedKeys = A\zip(null, $pos, $players); //key combination
//should return [['PG', 'Dragic'], ['SG', 'Reddick'], ['SF', 'Durant']]

$zippedFn = A\zip(
    function (string $player, string $pos) : string {
        return $player . ' is a ' . $pos;
    },
    $players,
    $pos
);
//should return ['Dragic is a PG', 'Reddick is a SG', 'Durant is a SF']
```

### Unzipping

The antithesis of zipping, unzipping involves transforming a zipped array into a multidimensional array of non-grouped arrays.

```php
//borrowing from the previous snippet

$unzipped = A\unzip($zippedKeys);
//should return [['PG', 'SG', 'SF'], ['Dragic', 'Reddick', 'Durant']]
```

### Identity

Central to the identity law of functors is the identity function. This function is pretty straightforward; it returns the value it receives with no transformations whatsoever.

```php

$id = A\identity('foo');
//should return foo
```

### Constant function

The constant function is one that always returns the first argument it receives.

```php

$const = A\constantFunction(1);
$const(); //should return 1
```

### Extend

The extend function is inspired by a similar bilby.js functional library. This helper is, in essence, used on arrays and allows one to append elements to them.

```php
$players = ['PG' => 'Dragic', 'SG' => 'Winslow'];

$extended = A\extend($players, ['SF' => 'Durant', 'PG' => 'Curry']);
//should return ['PG' => 'Curry', 'SG' => 'Winslow', 'SF' => 'Durant']
```
### Head function

The output of the head function is the first value of an array.

```php

$head = A\head([1, 2, 3, 4]);
//returns 1
```

### Tail function

Contrary to the head function, the tail function returns the second to last values in an array.

```php

$tail = A\tail([1, 2, 3, 4]);
//returns [2, 3, 4]
```

### Partitioning

The partition function one which can be used to create a multidimensional array expressed as a collection of smaller arrays of a defined size.

```php
$partitioned = A\partition(2, [1, 2, 3, 4]);
//returns [[1, 2], [3, 4]]
```

### Throttle function

The throttle function is used to defer function processing.

```php
$constDigit = A\constantFunction(12);

echo A\throttle($constDigit, 10);
//prints the digit 12 after 10 seconds
```

### isArrayOf function

Returns a string identifying the predominant type of the array. Arrays with more than one type are considered mixed.

```php
use Chemem\Bingo\Functional\Common\Callbacks as CB;

$integers = [1, 2, 3, 4];

echo A\isArrayOf($integers, CB\emptyArray);
//prints 'integer'
```

### concat function

The concat() function concatenates strings. It appends strings onto each other sequentially. It requires a wildcard separator though.

```php 
$wildcard = ' ';

echo A\concat($wildcard, 'Kampala', 'is', 'hot');
//should print 'Kampala is hot'
```

### Map function

The map function transforms each entry in a collection. The requirements for this are a function whose return value dictates the transformation and an array of values.

```php
$collection = [2, 4, 6, 8];

$squareOf = A\map(
    function (int $val) : int {
        return pow($val, 2);
    }, 
    $collection
); //should evaluate to [4, 16, 36, 64]
```

### Filter function

To filter is to make a selection based on a boolean predicate - the filter function, therefore, makes it possible to select array values based on a filter function's boolean return value.

```php
$collection = [1, 2, 3, 4, 5, 6];

$even = A\filter(
    function (int $val) : bool {
        return $val % 2 === 0;
    },
    $collection
);
//should return [2, 4, 6]
```

### Fold/Reduce function

The reduce function otherwise known as the fold function is one used purposely to transform a collection into a single value.

```php 
$collection = [1, 2, 3, 4, 5, 6];

$sumOfEven = A\fold(
    function (int $acc, int $val) : int {
        return $val % 2 === 0 ? $acc + $val : $acc;
    },
    $collection,
    0
); 
//should evaluate to 12
```

### Unique function

The unique function removes duplicates from an array.

```php
$numbers = [1, 2, 3, 4, 1];

$unique = A\unique($numbers); //should return [1, 2, 3, 4]
```

### Compact function

The compact function purges an array of falsey values (null, false).

```php
$collection = [1, 2, 3, false, null];

$numbers = A\compact($collection); //evaluates to [1, 2, 3]
```

### Drop function

The drop functions remove items from a list. The ```dropLeft()``` function removes elements from the front of a collection. The ```dropRight()``` function, on the other hand, removes elements from the back of a list.

```php
$even = [2, 4, 6, 8, 10, 12];

//dropLeft
$leftDrop = A\dropLeft($even, 3); //evaluates to [8, 10, 12]

//dropRight
$rightDrop = A\dropRight($even, 3); //evaluates to [2, 4, 6]
```

### Flatten function

The flatten function reduces an array level count by one.

```php
$collection = [[1, 2], 'foo', 'bar'];

$flattened = A\flatten($collection); //evaluates to [1, 2, 'foo', 'bar']
```

### ArrayKeysExist function

The arrayKeysExist function determines whether specified keys match the indexes of the values in an array and therefore exist in a collection.

```php
$attributes = ['username' => 'foo', 'password' => 'bar'];

$keysExist = A\arrayKeysExist($attributes, 'username', 'password'); //should evaluate to true
```

### Callback signatures

These are essential for proper functioning of the the following helper functions: ```pluck()```, ```pick()```, ```memoize()```, as well as ```isArrayOf()```. The following callback signatures correspond to the functions listed:

- ```invalidArrayKey :: key -> errMsg```

- ```invalidArrayValue :: key -> errMsg```

- ```memoizationError :: Callable fn -> errMsg```

- ```emptyArray :: Nothing -> errMsg``` 

**Note:** You can write your own callbacks provided they adhere to the signatures listed above.

## Functors

A functor is an entity derived from Category Mathematics. Functors allow one to map functions to one or more values defined in their context. Functors are, therefore, the data structures that form the basis for Monads, Applicatives, Just/Nothing types, and Left/Right types.

### Applicatives

An applicative is a functor which conforms to certain laws - interchange, map, identity, homomorphism, and interchange. The most pervasive element of applicatives is the ability to apply a function to the values in their context.

Functions, arrays, objects, and primitives can be encapsulated in Applicatives.

```php
use Chemem\Bingo\Functional\Functors\{CollectionApplicative, Applicative};

$num = Applicative::pure(10); //should return an integer, 10 encapsulated in an Applicative object

$addTen = Applicative::pure(
    function (int $a) : int {
        return $a + 10;
    }
); //should return a Closure object encapsulated in an Applicative object
```

#### CollectionApplicatives

Applicatives and CollectionApplicatives are not entirely dissimilar. The latter functors are indeed applicatives but more amenable to the creation of [ziplists](http://hackage.haskell.org/package/base-4.10.0.0/docs/Control-Applicative.html#v:ZipList), which are, fundamentally, traversable data structures.

```php
$zipList = CollectionApplicative::pure([
    $addTen,
    function (int $a) : int {
        return $a * 10;
    }
])
->apply(
    CollectionApplicative::pure([1, 2, 3])
)
->getValues();
//should return [11, 12, 13, 10, 20, 30]
```        

**Using the apply method**

The apply method is simply a means of binding an argument to a function defined in the context of an Applicative. It is especially convenient for state transformations within a functor environment.

```php

$addTen->apply($num)
    ->getValue(); //should return 20
```    

### Monad

The monad implementation in this library is a simple one. Considering the existence of a complete genealogy of monads, the monad class in this library is a microcosm of the feature. Monads allow us to manipulate values within their context like Applicatives but return monads of the same type when functions are bound to them.

```php
use Chemem\Bingo\Functional\Functors\Monad;

$val = Monad::return(10)
    ->bind(
        function (int $val) : int {
            return $val + 10;
        }
    ); //returns the value 10 encapsulated in a Monad object
```

***Monads*** map functions onto values stored inside their contexts whereas ***Applicatives*** bind values to the functions stored inside theirs.

**Note:** As of version 1.4.0, the Monad class will not be available. Refer to the [change log](https://github.com/ace411/bingo-functional/blob/master/docs/changes.md) for more details.

#### The IO Monad

The IO monad is one built purposely for handling impure operations. Impure operations are those that break referential transparency and immutability. Database interactions, Web service interaction, as well as external file reads are impediments to referential transparency.

```php
use Chemem\Bingo\Functional\Functors\Monads\IO;

$readFromFile = function () : string {
    return file_get_contents('path/to/file');
};

$io = IO::of($readFromFile)
    ->map('strtoupper')
    ->bind('var_dump')
    ->exec();
//should output the contents of a text file in uppercase
``` 

#### The Writer Monad

The Writer monad is designed to make tracking state changes less cumbersome. Unique in its design are a logging mechanism and state transformation helper functions.

```php
use Chemem\Bingo\Functional\Functors\Monads\Writer;

list($result, $log) = Writer::of(2, 'Initialize')
    ->bind(
        function (int $x) : int {
            return $x + 2;
        },
        'Add 2 to x val'
    )
    ->run();

echo $log;
//should output messages 'Initialize' and 'Add 2 to x val'
```

#### The Reader Monad

Environment variables, like impure operations, break referential transparency. The Reader monad is a solution to the problem of interacting with an external environment. The monad localizes state changes to ensure that functions are kept pure.

```php
use Chemem\Bingo\Functional\Functors\Monads\Reader;

function ask(string $content) : Reader
{
    return Reader::of(
        function (string $name) use ($content) {
            return $content . ($name === 'World' ? '' : ' How are you?'); 
        }
    );
}

function sayHello(string $name) : string
{
    return 'Hello ' . $name;
}

$reader = Reader::of('sayHello')
    ->withReader('ask')
    ->run('World');

echo $reader; //should output Hello World
```

#### The State Monad

Similar to the Reader monad is the State monad which works best in situations which require both the transformed and initial states.

```php
use Chemem\Bingo\Functional\Functors\Monads\State;

function addThree(int $val) : int
{
    return $val + 3;
}

function multiplyByTen(int $val) : int
{
    return $val * 10;
}

list($original, $finalState) = State::of(2)
    ->evalState('addThree')
    ->map('multiplyByTen')
    ->exec();

echo $original; //should output 2
echo $finalState; //should output 50
```

#### The List Monad

The List Monad is used to generate a set of values for a given collection - something akin to a zip list. The List Monad operates on the principle of [non-determinism](https://en.wikipedia.org/wiki/Nondeterministic_algorithm).

```php
use Chemem\Bingo\Functional\Functors\Monads\ListMonad;

function multiplyByTwo(int $val) : int
{
    return $val * 2;
}

$list = ListMonad::of(1, 2, 3)
    ->bind('multiplyByTwo')
    ->extract();
//should evaluate to [2, 4, 6, 1, 2, 3]
```

### Maybe Left/Nothing types

Borrowed from Haskell is the Maybe type which is composed of two subtypes, Just, and Nothing. The Just type is a functor to which one can bind a value intended for transformation whereas the Nothing type is a null value.

#### Maybe methods

- **fromValue()**

The ```fromValue()``` method is one used to bind a value to a Maybe type depending on whether the argument supplied is null or not.

```php
$val = Maybe::fromValue(10); //returns 10 encapsulated in a Right type object

$anotherVal = Maybe::fromValue(null); //returns Nothing - a null value

$yetAnotherVal = Maybe::fromValue(9, 9); //returns Nothing as the Just value and Nothing value cannot be the same
```

- **isJust() and isNothing()**

The ```isJust()``` and ```isNothing()``` methods simply return boolean values to indicate whether values are either of the Just type or the Nothing type.

```php

$var = Maybe::fromValue(33)
    ->isJust(); //returns true

$anotherVar = Maybe::fromValue(null)
    ->isNothing(); //returns true
```

### Either Left/Right types

Also borrowed from Haskell is the Either type which, like the Maybe type is comprised of two subtypes which are Left and Right. Naturally, the correct value, the one to be transformed, is an appendage of the Right type class. The error value is the constituent of the Left type class.

```php
use Chemem\Bingo\Functional\Functors\Either\{Either, Left, Right};

$val = Either::right(12); //correct value encapsulated in Right type
$err = Either::left('Invalid integer'); //error value encapsulated in Left type
```

#### Either methods

- **partitionEithers()**

As is the case with Haskell, the ```partitionEithers()``` method transforms an array of Either type items into a multidimensional array of left and right indexed sub-arrays.

```php

$eithers = [Either::right(12), Either::right(10), Either::left('Invalid Integer')];

$partitionedEithers = Either::partitionEithers($eithers);
//should return ['left' => ['Invalid Integer'], 'right' => [12, 10]]
```

#### Common methods

- **filter()**

The ```filter()``` method is one that returns a value which, in this case can be either Right or Just based on a boolean predicate. Usage is similar for both Right and Just types but slightly different for the former functor which requires an error value.

```php
$justVal = Maybe::just(2)
    ->filter(
        function (int $a) : bool {
            return is_int($a);
        }
    ); //should return 2 encapsulated in a Just type object

$rightval = Either::right('12')
    ->filter(
        function (string $a) : bool {
            return is_numeric($a);
        },
        'Value is not a numeric string'
    ); //should return '12' encapsulated in a Right type object
```

- **map()**

The ```map()``` method makes it possible to mutate functor context by enabling function binding.

```php

$justVal->map(
    function (int $a) : int {
        return $a + 10;
    }
); //should return 12 encapsulated in a Just type object
//should work in a similar way for Right type objects
```

- **flatMap()**

The ```flatMap()``` method works in a manner similar to the ```map()``` method but returns a non-encapsulated value.

```php

$justVal->flatMap(
    function (int $a) : int {
        return $a * 10;
    }
); //should return 20
```

- **orElse()**

The ```orElse()``` method returns a current value if there is one or a given value if there is one.

```php
$user = Either::right(get_current_user())
    ->orElse(
        Either::right('foo')
    ); //returns foo if the current script owner is not defined
```

- **lift()**

The ```lift()``` function allows functions expressed in point-free style or otherwise to accept Maybe type values or Either values as arguments.

```php
function add(int $a, int $b) : int
{
    return $a + $b;
}

$maybeLifted = Maybe::lift('add');
$eitherLifted = Either::lift('add', Either::left('Invalid Operation'));

$maybeLifted(
    Maybe::just(1),
    Maybe::just(2)
); //returns 3 encapsulated in a Just type object

$eitherLifted(
    Either::right(1),
    Either::right(2)
);
//returns 3 encapsulated in a Right type object
```
