---
title: collection-helpers
subTitle: Documentation for helper functions used on collections
---

## Picking

```
pick(array $collection, mixed $value)
```

**Since:** v1.0.0

**Arguments:**

- ***collection (array)*** - The array from which a value is to be picked
- ***value (mixed)*** - The value to pick

Picking is a means of selecting an item from a list. This list, is, usually an array.

```php

$list = ['Spurs', 'Rockets', 'Heat', 'Pelicans'];

$picked = A\pick($list, 'Heat'); //returns 'Heat'
```

## Plucking

```
pluck(array $collection, mixed $key)
```

**Since:** v1.0.0

**Arguments:**

- ***collection (array)*** - The array from which a value is to be picked
- ***key (mixed)*** - The key the corresponding value to which is returned

Like picking, plucking is a means of selecting an item from a list. The difference is in the means of selection. Plucking selects an item by index.

```php

$list = ['PG' => 'Dragic', 'SG' => 'Reddick', 'SF' => 'Durant'];

$plucked = A\pluck($list, 'SF'); //returns 'Durant'
```

## Zipping

```
zip(callable $function = null, array ...$arrays)
```

**Since:** v1.0.0

**Arguments:**

- ***function (callable)*** - The zip function
- ***arrays (array)*** - The arrays to zip

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

## Unzipping

```
unzip(array $zipped)
```

**Since:** v1.0.0

**Arguments:**

- ***zipped (array)*** - The zipped array

The antithesis of zipping, unzipping involves transforming a zipped array into a multidimensional array of non-grouped arrays.

```php
//borrowing from the previous snippet

$unzipped = A\unzip($zippedKeys);
//should return [['PG', 'SG', 'SF'], ['Dragic', 'Reddick', 'Durant']]
```

## Extend

```
extend(array ...arrays)
```

**Since:** v1.0.0

**Arguments:**

- ***arrays (array)*** - The arrays to combine

The extend function is inspired by a similar bilby.js functional library. This helper is, in essence, used on arrays and allows one to append elements to them.

```php
$players = ['PG' => 'Dragic', 'SG' => 'Winslow'];

$extended = A\extend($players, ['SF' => 'Durant', 'PG' => 'Curry']);
//should return ['PG' => 'Curry', 'SG' => 'Winslow', 'SF' => 'Durant']
```

## Head function

```
head(array $array)
```

**Since:** v1.1.0

**Arguments:**

- ***array (array)*** - The array whose first element is to be computed

The output of the head function is the first value of an array.

```php

$head = A\head([1, 2, 3, 4]);
//returns 1
```

## Tail function

```
tail(array $array)
```

**Since:** v1.1.0

**Arguments:**

- ***array (array)*** - The array whose elements other than the first are to be returned

Contrary to the head function, the tail function returns the second to last values in an array.

```php

$tail = A\tail([1, 2, 3, 4]);
//returns [2, 3, 4]
```

## indexOf function

```
indexOf(array $array, mixed $value)
```

**Since:** v1.8.0

**Arguments:**

- ***array (array)*** - The array from which an index of a list item is to be computed
- ***value (mixed)*** - The array item whose index is to be computed

The indexOf function computes the list index of a given list item.

```php
$index = A\indexOf([1, 2, 3, 4], 2);

echo $index; //outputs 1
``` 

## Fill function

```
fill(array $array, mixed $value, int $startIndex, int $endIndex)
```

**Since:** v1.8.0

**Arguments:**

- ***array (array)*** - The array to fill with a value
- ***value (mixed)*** - The fill value
- ***startIndex (int)*** - The first index whose corresponding value is to be replaced with fill value
- ***endIndex (int)*** - The last index whose corresponding value is to be replaced with fill value

The fill function replaces the values of specified list indexes with an arbitrary value.

```php
$filled = A\fill([2, 4, 6, 7], 3, 1, 2);

var_dump($filled); //outputs [2, 3, 3, 7]
```

## Partitioning

```
partition(int $size, array $array)
```

**Since:** v1.1.0

**Arguments:**

- ***size (int)*** - The size of the partitions
- ***array (array)*** - The array to partition

The partition function one which can be used to create a multidimensional array expressed as a collection of smaller arrays of a defined size.

```php
$partitioned = A\partition(2, [1, 2, 3, 4]);
//returns [[1, 2], [3, 4]]
```

## isArrayOf function

```
isArrayOf(array $array)
```

**Since:** v1.2.0

**Arguments:**

- ***array (array)*** - The array whose predominant type is to be ascertained

Returns a string identifying the predominant type of the array. Arrays with more than one type are considered mixed.

```php
$integers = [1, 2, 3, 4];

echo A\isArrayOf($integers);
//prints 'integer'
```

## concat function

```
concat(string $wildcard, string ...strings)
```

**Since:** v1.4.0

**Arguments:**

- ***wildcard (string)*** - The wildcard to be used
- ***strings (string)*** - The strings to concatenate

The concat() function concatenates strings. It appends strings onto each other sequentially. It requires a wildcard separator though.

```php 
$wildcard = ' ';

echo A\concat($wildcard, 'Kampala', 'is', 'hot');
//should print 'Kampala is hot'
```

## Map function

```
map(callable $function, array $collection)
```

**Since:** v1.5.0

**Arguments:**

- ***function (callable)*** - The function to map onto array values
- ***collection (array)*** - The array whose values are transformed

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

## Filter function

```
filter(callable $function, array $collection)
```

**Since:** v1.5.0

**Arguments:**

- ***function (callable)*** - The filter function
- ***collection (array)*** - The array whose values are evaluated

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

## Fold/Reduce function

```
fold/reduce(callable $function, array $collection, mixed $acc)
```

**Since:** v1.5.0

**Arguments:**

- ***function (callable)*** - The filter function
- ***collection (array)*** - The array whose values are evaluated
- ***acc (mixed)*** - The accumulator value

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

## Unique function

```
unique(array $array)
```

**Since:** v1.6.0

**Arguments:**

- ***array (array)*** - The array from which duplicates are purged

The unique function removes duplicates from an array.

```php
$numbers = [1, 2, 3, 4, 1];

$unique = A\unique($numbers); //should return [1, 2, 3, 4]
```

## Compact function

```
compact(array $array)
```

**Since:** v1.6.0

**Arguments:**

- ***array (array)*** - The array from which falsey values are purged

The compact function purges an array of falsey values (null, false).

```php
$collection = [1, 2, 3, false, null];

$numbers = A\compact($collection); //evaluates to [1, 2, 3]
```

## Drop function

```
dropLeft/dropRight(array $array, int $count)
```

**Since:** v1.6.0

**Arguments:**

- ***array (array)*** - The array from which values are to be dropped
- ***count (int)*** - The number of items to drop

The drop functions remove items from a list. The ```dropLeft()``` function removes elements from the front of a collection. The ```dropRight()``` function, on the other hand, removes elements from the back of a list.

```php
$even = [2, 4, 6, 8, 10, 12];

//dropLeft
$leftDrop = A\dropLeft($even, 3); //evaluates to [8, 10, 12]

//dropRight
$rightDrop = A\dropRight($even, 3); //evaluates to [2, 4, 6]
```

## Flatten function

```
flatten(array $array)
```

**Since:** v1.6.0

**Arguments:**

- ***array (array)*** - The array to flatten

The flatten function reduces an array level count by one.

```php
$collection = [[1, 2], 'foo', 'bar'];

$flattened = A\flatten($collection); //evaluates to [1, 2, 'foo', 'bar']
```

## ArrayKeysExist function

```
arrayKeysExist(array $array, mixed ...$keys)
```

**Since:** v1.6.0

**Arguments:**

- ***array (array)*** - The array whose keys are to be assessed
- ***keys (mixed)*** - The keys whose existence is to be ascertained

The arrayKeysExist function determines whether specified keys match the indexes of the values in an array and therefore exist in a collection.

```php
$attributes = ['username' => 'foo', 'password' => 'bar'];

$keysExist = A\arrayKeysExist($attributes, 'username', 'password'); //should evaluate to true
```

## Reverse function

```
reverse(array $array)
```

**Since:** v1.8.0

**Arguments:**

- ***array (array)*** - The array whose order is to be reversed

The reverse function computes the reverse of an array.

```php
$reverse = A\reverse(['foo', 'bar', 'baz']);

var_dump($reverse); //outputs ['baz', 'bar', 'foo']
```

## ToPairs function

```
toPairs(array $array)
```

**Since:** v1.6.0

**Arguments:**

- ***array (array)*** - The array from which pairs are to be formed

The toPairs function combines key-value pairs into discrete array pairs.

```php
$toPairs = A\toPairs(['foo' => 'baz', 'bar' => 'baz', 'boo' => 1]);

var_dump($toPairs); //prints [['foo', 'baz'], ['bar', 'baz'], ['boo', 1]]
```

## FromPairs function

```
fromPairs(array $array)
```

**Since:** v1.8.0

**Arguments:**

- ***array (array)*** - A key-value collection

The fromPairs function forms key-value pairs from discrete array pairs - it is the opposite of the toPairs function.

```php
$fromPairs = A\fromPairs([['foo', 'baz'], ['bar', 'baz'], ['boo', 1]]);

var_dump($fromPairs); //outputs ['foo' => 'baz', 'bar' => 'baz', 'boo' => 1]
```