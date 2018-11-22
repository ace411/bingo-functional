---
logo: bingo-functional-logo.png
description: Documentation for functors
prev: /immutable-lists.html
prevTitle: Immutable Lists
next: /repl.html
nextTitle: Console
---
# Functors

A functor is an entity derived from Category Mathematics. Functors allow one to map functions to one or more values defined in their context. Functors are, therefore, the data structures that form the basis for Monads, Applicatives, Just/Nothing types, and Left/Right types.

## Applicatives

An applicative is a functor which conforms to certain laws - interchange, map, identity, and homomorphism. The most pervasive element of applicatives is the ability to apply a function to the values in their context.

Functions, arrays, objects, and primitives can be encapsulated in Applicatives.

```php
use Chemem\Bingo\Functional\Functors\{CollectionApplicative, Applicative};

$num = Applicative::pure(10); //should return an integer, 10 encapsulated in an Applicative object

$addTen = Applicative::pure(function (int $a) : int { return $a + 10; }); 
//should return a Closure object encapsulated in an Applicative object
```

### CollectionApplicatives

- **Note:** This feature is not available in versions ***1.9.0*** and ***upwards***.

Applicatives and CollectionApplicatives are not entirely dissimilar. The latter functors are indeed applicatives but more amenable to the creation of [ziplists](http://hackage.haskell.org/package/base-4.10.0.0/docs/Control-Applicative.html#v:ZipList), which are, fundamentally, traversable data structures.

```php
$zipList = CollectionApplicative::pure([
    $addTen,
    function (int $a) : int { return $a * 10; }
])
->apply(CollectionApplicative::pure([1, 2, 3]))
->getValues();
//should return [11, 12, 13, 10, 20, 30]
```        

**Using the apply method** - For versions **1.9.0** and **lower**

The apply method is simply a means of binding an argument to a function defined in the context of an Applicative. It is especially convenient for state transformations within a functor environment.

```php
$addTen->apply($num)
    ->getValue(); //should return 20
```

**Using the ap method** - For versions **1.10.0** and **upwards**

## Monad

The monad implementation in this library is a simple one. Considering the existence of a complete genealogy of monads, the monad class in this library is a microcosm of the feature. Monads allow us to manipulate values within their context like Applicatives but return monads of the same type when functions are bound to them.

```php
use Chemem\Bingo\Functional\Functors\Monad;

$val = Monad::return(10)
    ->bind(function (int $val) : int { return $val + 10; }); 
//returns the value 10 encapsulated in a Monad object
```

***Monads*** map functions onto values stored inside their contexts whereas ***Applicatives*** bind values to the functions stored inside theirs.

**Note:** As of version 1.4.0, the Monad class will not be available. Refer to the [change log](https://github.com/ace411/bingo-functional/blob/master/docs/changes.md) for more details.

### The IO Monad

The IO monad is one built purposely for handling impure operations. Impure operations are those that break referential transparency and immutability. Database interactions, web service interaction, as well as external file reads are impediments to referential transparency.

```php
use Chemem\Bingo\Functional\Functors\Monads\IO;

$io = IO::of(function () : string { return file_get_contents('path/to/file'); })
    ->map('strtoupper')
    ->bind('var_dump')
    ->exec();
//should output the contents of a text file in uppercase
``` 

### IO functions
> Adapted from [Haskell](http://hackage.haskell.org/package/base-4.11.1.0/docs/Prelude.html#g:26).

#### IO\IO
```
IO\IO(mixed $io)
```

**Since:** v1.11.0

**Arguments:**

- ***io (mixed)*** - An IO operation to store inside the IO monad

Calls the ```IO``` monad constructor thereby initializing a value of type ```IO```.

```php
use Chemem\Bingo\Functional\Functors\Monads\IO;

$_io = IO\IO(file_get_contents('path/to/file'));
```

#### IO\putChar
```
IO\putChar()
```

**Since:** v1.11.0

**Arguments:**
> None

Write a character from the standard input device.

```php
$contents = IO\putChar();
```

#### IO\getChar
```
IO\getChar()
```

**Since:** v1.11.0

**Arguments:**
> None

Read a character from the standard input device.

```php
$contents = IO\readChar();
```

#### IO\putStr
```
IO\putChar()
```

**Since:** v1.11.0

**Arguments:**
> None

Write a string to the standard output device.

```php
$contents = IO\putStr();
```

#### IO\getLine
```
IO\getLine()
```

**Since:** v1.11.0

**Arguments:**
> None

Read a line from the standard input device

```php
$contents = IO\getLine();
```

#### IO\interact
```
IO\interact(callable $function)
```

**Since:** v1.11.0

**Arguments:**

- ***function (callable)*** - A string data manipulation function

Parses Standard Input device string data and maps a function onto it.

```php
$contents = IO\interact('strtoupper');
```

#### IO\_print
```
IO\_print(IO $printable)
```

**Since:** v1.11.0

**Arguments:**

- ***printable (IO)*** - Data of a printable type

Outputs data of any printable type to an output device.

```php
use Chemem\Bingo\Functional\Functors\Monads as M;

$contents = M\mcompose(IO\_print, function (string $data) {
    $ret = A\compose('strtolower', IO\IO, IO\IO);
    return $ret($data);
});

$contents(IO\IO('chemem'));
```

#### IO\readFile
```
IO\readFile(string $path)
```

**Since:** v1.11.0

**Arguments:**

- ***path (string)*** - The file path

Reads a file and returns the contents of the file as a string.

```php
$contents = IO\readFile('path/to/file');
```

#### IO\writeFile
```
IO\writeFile(string $path, string $content)
```

**Since:** v1.11.0

**Arguments:**

- ***path (string)*** - The file path
- ***content (string)*** - The contents to write to a file

Writes data to a file.

```php
$contents = IO\writeFile('path/to/file', 'foo');
```

#### IO\appendFile
```
IO\appendFile(string $path, string $content)
```

**Since:** v1.11.0

**Arguments:**

- ***path (string)*** - The file path
- ***content (string)*** - The data to append

Appends data to a file.

```php
$contents = IO\appendFile('path/to/file', 'foo');
```

#### IO\readIO
```
IO\readIO(IO $contents)
```

**Since:** v1.11.0

**Arguments:**

- ***contents (IO)*** - String content wrapped inside IO monad

Reads data from an external source and signals a parse failure to the IO monad.

```php
$contents = M\mcompose(readIO, function () {
    return M\bind(function ($fgets) {
        $ret = A\compose($fgets, IO\IO, IO\IO);
        return $ret(STDIN); //get input from console
    }, IO\putStr());
});

$contents(IO\IO(null));
```

### The Writer Monad

The Writer monad is designed to make tracking state changes less cumbersome. Unique in its design are a logging mechanism and state transformation helper functions.

```php
use Chemem\Bingo\Functional\Functors\Monads\Writer;

list($result, $log) = Writer::of(2, 'Initialize')
    ->bind(
        function (int $x) : int { return $x + 2;},
        'Add 2 to x val'
    )
    ->run();

echo $log;
//should output messages 'Initialize' and 'Add 2 to x val'
```

### The Reader Monad

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

### The State Monad

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

### The List Monad

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

## Maybe Left/Nothing types

Borrowed from Haskell is the Maybe type which is composed of two subtypes, Just, and Nothing. The Just type is a functor to which one can bind a value intended for transformation whereas the Nothing type is a null value.

### Maybe methods

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

## Either Left/Right types

Also borrowed from Haskell is the Either type which, like the Maybe type is comprised of two subtypes which are Left and Right. Naturally, the correct value, the one to be transformed, is an appendage of the Right type class. The error value is the constituent of the Left type class.

```php
use Chemem\Bingo\Functional\Functors\Either\{Either, Left, Right};

$val = Either::right(12); //correct value encapsulated in Right type
$err = Either::left('Invalid integer'); //error value encapsulated in Left type
```

### Either methods

- **partitionEithers()**

As is the case with Haskell, the ```partitionEithers()``` method transforms an array of Either type items into a multidimensional array of left and right indexed sub-arrays.

```php
$eithers = [Either::right(12), Either::right(10), Either::left('Invalid Integer')];

$partitionedEithers = Either::partitionEithers($eithers);
//should return ['left' => ['Invalid Integer'], 'right' => [12, 10]]
```

### Common methods

- **filter()**

The ```filter()``` method is one that returns a value which, in this case can be either Right or Just based on a boolean predicate. Usage is similar for both Right and Just types but slightly different for the former functor which requires an error value.

```php
$justVal = Maybe::just(2)
    ->filter(function (int $a) : bool { return is_int($a); }); 
//should return 2 encapsulated in a Just type object

$rightval = Either::right('12')
    ->filter(
        function (string $a) : bool { return is_numeric($a); },
        'Value is not a numeric string'
    ); //should return '12' encapsulated in a Right type object
```

- **map()**

The ```map()``` method makes it possible to mutate functor context by enabling function binding.

```php
$justVal->map(function (int $a) : int { return $a + 10; }); 
//should return 12 encapsulated in a Just type object
//should work in a similar way for Right type objects
```

- **flatMap()**

The ```flatMap()``` method works in a manner similar to the ```map()``` method but returns a non-encapsulated value.

```php
$justVal->flatMap(function (int $a) : int { return $a * 10; }); 
//should return 20
```

- **orElse()**

The ```orElse()``` method returns a current value if there is one or a given value if there is one.

```php
$user = Either::right(get_current_user())
    ->orElse(Either::right('foo')); 
//returns foo if the current script owner is not defined
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

$maybeLifted(Maybe::just(1), Maybe::just(2)); 
//returns 3 encapsulated in a Just type object

$eitherLifted(Either::right(1), Either::right(2));
//returns 3 encapsulated in a Right type object
```
