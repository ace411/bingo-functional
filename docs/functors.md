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

### Applicative Functions
> Adapted from [Haskell](http://hackage.haskell.org/package/base-4.12.0.0/docs/Control-Applicative.html)

#### Applicative\pure
```
Applicative\pure(mixed $value)
```

**Since:** v1.11.0

**Arguments**

- ***value (mixed)*** - An arbitrary value

Lifts a value.

```php
use Chemem\Bingo\Functional\Functors\Applicatives\Applicative;

$app = Applicative\pure(function (string $text) {
    return substr($text, 0, (5 - mb_strlen($text)));
});
```

#### Applicative\liftA2
```
Applicative\liftA2(callable $function, Applicative ...$values)
```

**Since:** v1.11.0

**Arguments**

- ***function (callable)*** - Lift function
- ***values (Applicative)*** - Instance(s) of Applicative

Lifts a binary function to actions.

```php
$ret = Applicative\liftA2(function ($val) {
    return ($val / 2) * pow($val, $val / 5);
}, Applicative\pure(12), Applicative\pure(9));
```

### CollectionApplicatives

- **Note:** This feature is not available in versions ***1.9.0*** and ***upwards***. Consider using the [ListMonad](#the-list-monad) instead.

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

```php
$action = Applicative::pure(function ($val) {
    return pow($val, 3) / 4;
})->ap(Applicative::pure(2));
```

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

### Monad functions
> Adapted from [Haskell](http://hackage.haskell.org/package/base-4.12.0.0/docs/Prelude.html#v:-62--62--61-)

#### Monads\bind
```
Monads\bind(callable $actionB, object $actionB)
```

**Since:** v1.11.0

**Arguments**

- ***actionB (callable)*** - Function that evaluates to a Monadic value
- ***actionA (object)*** - Monad instance (IO, ListMonad, State, Writer, Reader, Either, Maybe) 

Sequentially composes two actions - passing any value produced by the first as an argument to the second.

```php
use Chemem\Bingo\Functional\Algorithms as A;
use Chemem\Bingo\Functional\Functors\Monads\IO;
use Chemem\Bingo\Functional\Functors\Monads as M;

$ret = M\bind(function (string $contents) {
    $res = A\compose('json_encode', 'json_decode', IO\IO);
    return $res($contents);
}, IO\IO(file_get_contents('path/to/json/file')));
```

#### Monads\mcompose
```
Monads\mcompose(callable $valB, callable $valA)
```

**Since:** v1.11.0

**Arguments**

- ***valA (callable)*** - Monadic value
- ***valB (callable)*** - Monadic value

Composes two monadic values from right to left.

```php
$ret = M\mcompose(A\partial(IO\appendFile, 'path/to/file'), IO\readFile);

$ret(IO\IO('path/to/another/file'));
```

### The IO Monad

The IO monad is one built purposely for handling impure operations. Impure operations are those that break referential transparency and immutability. Database interactions, web service interaction, as well as external file reads are impediments to referential transparency.

```php
use Chemem\Bingo\Functional\Functors\Monads\IO;

$io = IO::of(file_get_contents('path/to/file'))
    ->map('strtoupper')
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
    ->run();

echo $log;
//should output messages 'Initialize' and 'Add 2 to x val'
```

### Writer functions
> Adapated from [Haskell](http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Writer-Lazy.html#g:2)

#### Writer\writer
```
Writer\writer(mixed $result, mixed $output)
```

**Since:** v1.11.0

**Arguments:**

- ***result (mixed)*** - Primary monad input
- ***output (mixed)*** - Ancillary log data

Calls the ```Writer``` monad constructor thereby initializing a value of type ```Writer```.

```php
use Chemem\Bingo\Functional\Functors\Monads\Writer;

$data = Writer\writer(12, 'add 12');
```

#### Writer\runWriter
```
Writer\runWriter(Writer $writer)
```

**Since:** v1.11.0

**Arguments:**

- ***writer (Writer)*** - Writer computation

Unwraps a writer computation as a ```[result, output]``` pair.

```php
$writer = Writer\writer(1, 'put 1');

list($result, $output) = Writer\runWriter($writer);
```

#### Writer\execWriter
```
Writer\execWriter(Writer $writer)
```

**Since:** v1.11.0

**Arguments:**

- ***writer (Writer)*** - Writer computation

Extracts the output from a writer computation.

```php
$writer = Writer\writer(10, 55);

$output = Writer\execWriter($writer);
```

#### Writer\mapWriter
```
Writer\mapWriter(callable $function, Writer $writer)
```

**Since:** v1.11.0

**Arguments:**

- ***function (callable)*** - Function to map onto result and output
- ***writer (Writer)*** - Writer computation

Maps a function onto the result and output of the Writer monad.

```php
$res = M\bind(
    A\partial(Writer\mapWriter, function ($val) {
        return $val / 5;
    }),
    Writer\writer(5, 10)
);
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

### Reader Functions
> Adapated from [Haskell](http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Reader.html#g:1)

#### Reader\reader
```
Reader\reader(mixed $value)
```

**Since:** v1.11.0

**Arguments:**

- ***value (mixed)*** - Value to put in reader environment

Puts a value in a Reader environment - calls the ```Reader``` monad constructor and initializes a value of type ```Reader```.

```php
$reader = Reader\reader(function ($name) {
    return A\concat(' ', 'Hello', ($name == 'loki' ? 'Loki' : 'world'));
});
```

#### Reader\runReader
```
Reader\runReader(Reader $reader, mixed $value)
```

**Since:** v1.11.0

**Arguments:**

- ***reader (Reader)*** - Reader value
- ***value (mixed)*** - Arbitrary value applied to Reader

Applies an arbitrary value to a ```Reader``` and extracts a value from it.

```php
$reader = Reader\reader(function ($name) {
    return 'Hello ' . $name . '.';
});

$ret = Reader\runReader($reader, 'Loki');
```

#### Reader\mapReader
```
Reader\mapReader(callable $function, Reader $reader)
```

**Since:** v1.11.0

**Arguments:**
- ***function (callable)*** - Function to map onto value in Reader environment
- ***reader (Reader)*** - Reader value

Applies function to value in ```Reader``` environment.

```php
$ask = Reader\reader(function (string $name) {
    return 'Hi ' . $name;
});

$map = Reader\mapReader(function (string $sal) {
    return $sal . '. How are you feeling today?';
}, $ask);
```

#### Reader\withReader
```
Reader\withReader(callable $function, Reader $reader)
```

**Since:** v1.11.0

**Arguments:**
- ***function (callable)*** - Function to map onto value in Reader environment
- ***reader (Reader)*** - Reader value

Executes a computation in a modified ```Reader``` environment.

```php
$ask = Reader\reader(function (int $age) {
    return A\concat(' ', 'You are', $age, 'years old.');
});

$trans = Reader\withReader(function (string $stmt) {
    return Reader\reader(function (int $age) use ($stmt) {
        return $stmt . ($age > 18 ? 'You are an adult.' : 'You\'ll be an adult someday.');
    });
}, $ask);
```

#### Reader\ask
```
Reader\ask()
```

**Since:** v1.11.0

**Arguments:**
> None

Retrieves the ```Reader``` monad environment.

```php
$env = Reader\ask();
```

### The State Monad

Similar to the Reader monad is the State monad which works best in situations which require both the transformed and initial states.

```php
use Chemem\Bingo\Functional\Functors\Monads\State;

$result = State::of(2)
    ->bind(function ($state) {
        return State::of($state + 3);
    })
    ->run(3);
    
print_r($result); //prints [5, 3]
```

### State Functions
> Adapated from [Haskell](http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html)

#### State\state
```
State\state(callable $action)
```

**Since:** v1.11.0

**Arguments:**

- ***action (callable)*** - action to embed in State monad

Embeds a simple action into the ```State``` monad.

```php
$state = State\state(function ($val) {
    return $val * 2;
});
```

#### State\put
```
State\put(mixed $value)
```

**Since:** v1.11.0

**Arguments:**

- ***value (mixed)*** - value to put in State context

Replaces the state inside the ```State``` monad.

```php
$put = State\put('foo');
```

#### State\get
```
State\get()
```

**Since:** v1.11.0

**Arguments:**
> None

Returns the state from the internals of the ```State``` monad.

```php
$state = State\get();
```

#### State\gets
```
State\gets(callable $projection)
```

**Since:** v1.11.0

**Arguments:**

- ***projection (callable)*** - function to transform a portion of the state

Gets specific component of the state, using a projection function supplied.

```php
$state = State\gets(function ($state) {
    $ret = A\compose('strtolower', 'ucfirst');
    return $ret($state);
});

$res = State\evalState($state, null)('loki');
```

#### State\modify
```
State\modify(callable $function)
```

**Since:** v1.11.0

**Arguments:**

- ***function (callable)*** - function to map onto old state

Maps an old state to a new state inside a ```State``` monad.

```php
$modify = State\modify(function ($state) {
    return pow($state, 2) / 4;
});

$ret = State\evalState($modify, null)(8);
```

#### State\runState
```
State\runState(State $state, mixed $value)
```

**Since:** v1.11.0

**Arguments:**

- ***state (State)*** - State monad instance
- ***value (mixed)*** - Value to apply to State monad

Unwraps a ```State``` monad compuation.

```php
$val = State\runState(State\put(2), 3);
```

#### State\evalState
```
State\evalState(State $state, mixed $value)
```

**Since:** v1.11.0

**Arguments:**

- ***state (State)*** - State monad instance
- ***value (mixed)*** - Value to apply to State monad

Evaluates a state computation with the given initial state; returns the final value.

```php
$ret = State\evalState(State\put(2), 3);
```

#### State\execState
```
State\execState(State $state, mixed $value)
```

**Since:** v1.11.0

**Arguments:**

- ***state (State)*** - State monad instance
- ***value (mixed)*** - Value to apply to State monad

Evaluates a state computation with the given initial state; returns the final state.

```php
$state = State\evalState(State\put('foo'), 'bar');
```

### The List Monad

The List Monad is used to generate a set of values for a given collection - something akin to a zip list. The List Monad operates on the principle of [non-determinism](https://en.wikipedia.org/wiki/Nondeterministic_algorithm).

The implementation of the ListMonad in this library is reliant on PHP hashtables (arrays).

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

### ListMonad functions
> Adapted from [Haskell](http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-List.html)

#### ListMonad\fromValue
```
ListMonad\fromValue(mixed $value)
```

**Since:** v1.11.0

**Arguments**

- ***value (mixed)*** - An arbitrary value to store in a List

Adds a value to a list - calls the ```ListMonad``` constructor thereby initializing a value of type ```ListMonad```.

```php
use Chemem\Bingo\Functional\Functors\Monads\ListMonad;

$list = ListMonad\fromValue(2);
```

#### ListMonad\concat
```
ListMonad\concat(ListMonad ...$list)
```

**Since:** v1.11.0

**Arguments**

- ***list (ListMonad)*** - instance of ListMonad

Creates a large list from multiple instances of the ```ListMonad```.

```php
$mult = ListMonad\concat(ListMonad\fromValue(12), ListMonad\fromValue(9)); 
```

#### ListMonad\prepend
```
ListMonad\prepend(ListMonad $prep, ListMonad $list)
```

**Since:** v1.11.0

**Arguments**

- ***list (ListMonad)*** - instance of ListMonad
- ***prep (ListMonad)*** - instance of ListMonad to add to front of list

Inserts the items of one list into the beginning of another.

```php
$list = ListMonad\prepend(ListMonad\fromValue(2), ListMonad\fromValue([4, 6, 8, 10]));
```

#### ListMonad\append
```
ListMonad\append(ListMonad $app, ListMonad $list)
```

**Since:** v1.11.0

**Arguments**

- ***list (ListMonad)*** - instance of ListMonad
- ***app (ListMonad)*** - instance of ListMonad to add to front of list

Adds the items of one list to the end of another.

```php
$list = ListMonad\append(ListMonad\fromValue([3, 5, 7, 9]), ListMonad\fromValue(11));
```

#### ListMonad\head
```
ListMonad\head(ListMonad $list)
```

**Since:** v1.11.0

**Arguments**

- ***list (ListMonad)*** - instance of ListMonad

Returns the first element in a list.

```php
$head = ListMonad\head(ListMonad\fromValue([3, 4, 5]));
```

#### ListMonad\tail
```
ListMonad\tail(ListMonad $list)
```

**Since:** v1.11.0

**Arguments**

- ***list (ListMonad)*** - instance of ListMonad

Returns the last element in a list.

```php
$head = ListMonad\last(ListMonad\fromValue([3, 4, 5]));
```

## Maybe Just/Nothing types

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

### Maybe functions
> Adapted from [Haskell](hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html)

#### Maybe\maybe
```
Maybe\maybe(mixed $default, callable $function, Maybe $maybe)
```

**Since:** - v1.11.0

**Arguments**

- ***default (mixed)*** - arbitrary default value
- ***function (callable)*** - function to map onto Just-value
- ***maybe (Maybe)*** - instance of Maybe monad

Performs case analysis for the Maybe monad: applies function to Just-value if ```Maybe``` value is not ```Nothing``` - default value otherwise.

```php
use Chemem\Bingo\Functional\Functors\Maybe;

$maybe = Maybe\Maybe::fromValue(12)
    ->filter(function ($val) {
        return $val > 15;
    });

$ret = Maybe\maybe('Error: value is lower than 15', function ($val) {
    return pow($val, 2) / 18;
}, $maybe);
```

#### Maybe\isJust
```
Maybe\isJust(Maybe $maybe)
```

**Since:** - v1.11.0

**Arguments**

- ***maybe (Maybe)*** - instance of Maybe monad

Returns ```true``` if the given value is a Just-value, ```false``` otherwise.

```php
$check = Maybe\isJust(Maybe\Maybe::fromValue(2));
```

#### Maybe\isNothing
```
Maybe\isNothing(Maybe $maybe)
```

**Since:** - v1.11.0

**Arguments**

- ***maybe (Maybe)*** - instance of Maybe monad

Returns ```true``` if the given value is ```Nothing```, ```false``` otherwise.

```php
$check = Maybe\isNothing(Maybe\Maybe::fromValue(2, 2));
```

#### Maybe\fromJust
```
Maybe\fromJust(Maybe $maybe)
```

**Since:** v1.11.0

**Arguments**

- ***maybe (Maybe)*** - instance of Maybe monad

Extracts the element from a ```Just``` instance and throws an error if its argument is ```Nothing```.

```php
$val = Maybe\fromJust(Maybe\Maybe::fromValue(8));
```

#### Maybe\fromMaybe
```
Maybe\fromMaybe(mixed $default, Maybe $maybe)
```

**Since:** v1.11.0

**Arguments**

- ***default (mixed)*** - arbitrary default value
- ***maybe (Maybe)*** - instance of Maybe monad

Works like the ```Maybe\fromJust``` function but returns a default value if the Maybe-value is of type ```Nothing```.

```php
$val = Maybe\fromMaybe(8, Maybe\Maybe::nothing());
```

#### Maybe\listToMaybe
```
Maybe\listToMaybe(array $list)
```

**Since:** v1.11.0

**Arguments**

- ***list (array)*** - an array

Returns ```Nothing``` on an empty list or the first element of the list encapsulated in a ```Just``` instance.

```php
$ret = Maybe\listToMaybe(range(3, 7));
```

#### Maybe\maybeToList
```
Maybe\maybeToList(Maybe $maybe)
```

**Since:** v1.11.0

**Arguments**

- ***maybe (Maybe)*** - instance of Maybe monad

Returns an empty list when Maybe value is of type Nothing and a Singleton list otherwise.

```php
$ret = Maybe\maybeToList(Maybe\Maybe::just('foo'));
```

#### Maybe\catMaybes
```
Maybe\catMaybes(array $maybes)
```

**Since:** v1.11.0

**Arguments**

- ***maybes (array)*** - an array of Maybe-type values

Takes a list of Maybes and returns a list of all the Just values.

```php
$res = Maybe\catMaybes([
    Maybe\Maybe::just(12),
    Maybe\Maybe::nothing(),
    Maybe\Maybe::just(2)
]);
```

#### Maybe\mapMaybe
```
Maybe\mapMaybe(callable $function, array $values)
```

**Since:** v1.11.0

**Arguments**

- ***function (callable)*** - a function to map onto list
- ***values (array)*** - a list of values

The ```mapMaybe``` function is a version of ```map```, specific to the Maybe type, which can throw out elements.

```php
$ret = Maybe\mapMaybe(function ($val) {
    return Maybe\Maybe::just($val * 2);
}, range(1, 4));
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

- **Note:** The ```partitionEithers``` function is not available as a static method beyond v1.10.0. It is, in subsequent version(s), exclusively a function in the namespace ```Chemem\Bingo\Functional\Functors\Either```.

### Either functions
> Adapted from [Haskell](http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html)

#### Either\either
```
Either\either(callable $left, callable $right, Either $either)
```

**Since:** - v1.11.0

**Arguments**

- ***left (callable)*** - function to apply to an instance of ```Either\Left```
- ***right (callable)*** - function to apply to an instance of ```Either\Right```
- ***either (Either)*** - instance of ```Either``` monad

Performs case analysis for the ```Either``` monad: applies the Right-value function to a ```Right``` instance of an Either type and a Left-value function to a ```Left``` instance of the same monad.

```php
use Chemem\Bingo\Functional\Functors\Either;

$either = Either\Either::right(12)
    ->filter(function (int $val) {
        return $val > 15;
    }, 'Error > Value is less than 15');

$case = Either\either(A\partial('str_replace', ' >', ':'), function ($result) {
    return pow($result, 2) / 18;
}, $either);
```

#### Either\isRight
```
Either\isRight(Either $either)
```

**Since:** - v1.11.0

**Arguments**

- ***either (Either)*** - instance of Either monad

Returns ```true``` if the given value is a Right-value, ```false``` otherwise.

```php
$check = Either\isRight(Either\Either::right(2));
```

#### Either\isLeft
```
Either\isLeft(Either $either)
```

**Since:** - v1.11.0

**Arguments**

- ***either (Either)*** - instance of Either monad

Returns ```true``` if the given value is a Left-value, ```false``` otherwise.

```php
$check = Either\isLeft(Either\Either::left(2));
```

#### Either\rights
```
Either\rights(array $eithers)
```

**Since:** - v1.11.0

**Arguments**

- ***eithers (array)*** - A list of ```Either``` type values

Extracts from a list of ```Either``` values - all the ```Right``` elements.

```php
$val = Either\rights([
    Either\Either::right(12),
    Either\Either::left('Error!'),
    Either\Either::right('foo')
]);
```

#### Either\lefts
```
Either\lefts(array $eithers)
```

**Since:** - v1.11.0

**Arguments**

- ***eithers (array)*** - A list of ```Either``` type values

Extracts from a list of ```Either``` values - all the ```Left``` elements.

```php
$val = Either\lefts([
    Either\Either::right(12),
    Either\Either::left('Error!'),
    Either\Either::right('foo')
]);
```

#### Either\fromRight
```
Either\fromRight(mixed $default, Either $either)
```

**Since:** - v1.11.0

**Arguments**

- ***default (mixed)*** - Arbitrary default value
- ***either (Either)*** - Instance of Either monad

Returns the contents of a Right-value or a default value otherwise.

```php
$eth = Either\fromRight(55, Either\Either::left(10));
```

#### Either\fromLeft
```
Either\fromLeft(mixed $default, Either $either)
```

**Since:** - v1.11.0

**Arguments**

- ***default (mixed)*** - Arbitrary default value
- ***either (Either)*** - Instance of Either monad

Returns the contents of a Left-value or a default value otherwise.

```php
$eth = Either\fromLeft('bar', Either\Either::right('foo'));
```

#### Either\partitionEithers
```
Either\partitionEithers(array $eithers)
```

**Since:** v1.11.0

Check out the ```partitionEithers``` docs in the antecedent text.

### Common methods

- **filter()**

The ```filter()``` method is one that returns a value which, in this case can be either Right or Just based on a boolean predicate. Usage is similar for both Right and Just types but slightly different for the former functor which requires an error value.

```php
$justVal = Maybe::just(2)
    ->filter(function (int $a) : bool { return is_int($a); }); 
//should return 2 encapsulated in a Just type object

$rightval = Either::right('12')
    ->filter(function (string $a) : bool { 
        return is_numeric($a); 
    }, 'Value is not a numeric string'); 
//should return '12' encapsulated in a Right type object
```

- **map()**

The ```map()``` method makes it possible to mutate functor context by enabling function binding.

```php
$justVal->map(function (int $a) : int { 
    return $a + 10; 
}); 
//should return 12 encapsulated in a Just type object
//should work in a similar way for Right type objects
```

- **flatMap()**

The ```flatMap()``` method works in a manner similar to the ```map()``` method but returns a non-encapsulated value.

```php
$justVal->flatMap(function (int $a) : int { 
    return $a * 10; 
}); 
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
