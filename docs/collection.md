# Collection Helpers

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
zip(array ...$arrays)
```

**Since:** v1.0.0

**Arguments:**

- ***function (callable)*** - The zip function
- ***arrays (array)*** - The arrays to zip

Also used to manipulate lists is zipping. A zipped array is a multidimensional array of grouped arrays. It can be created either via function binding or array key combination.

```php

$pos = ['PG', 'SG', 'SF'];
$players = ['Dragic', 'Reddick', 'Durant'];

$zippedKeys = A\zip($pos, $players); //key combination
//should return [['PG', 'Dragic'], ['SG', 'Reddick'], ['SF', 'Durant']]
```

## zipWith function

```
zipWith(callable $function, array ...$list)
```

**Since:** v1.12.0

**Argument(s):**

- ***function (callable)*** - The zip function
- ***list (array)*** - The arrays to zip 

Zips two lists based on the result of a zip function.

```php
$zipped = A\zipWith(function (int $num, int $str) : int {
    return $num + mb_strlen($str, 'utf-8');
}, range(1, 3), ['foo', 'bar', 'baz']);
//outputs [4, 5, 6]
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

## Last function

```
last(array $array)
```

**Since:** v1.10.0

**Arguments:**

- ***array (array)*** - The array whose first element is to be computed

The output of the last function is the last value of an array.

```php
$last = A\last([4, 5, 6, 1]);
//outputs 1
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

## mapDeep function

```
mapDeep(callable $function, array $collection)
```

**Since:** v1.10.0

**Arguments:**

- ***function (callable)*** - The function to map onto array values
- ***collection (array)*** - The array whose values are transformed

The mapDeep function applies a function to every value in a multi-dimensional array.

```php
const NUMBERS = [
    'prime' => [2, 5, 7, 11],
    'odd' => [3, 5, [7, 9]]
];

$list = A\mapDeep(function ($val) { return pow($val, 2); }, NUMBERS);
//outputs ['prime' => [4, 25, 49, 121], 'odd' => [9, 25, [49, 81]]]
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

## Reject function

```
reject(callable $function, array $collection)
```

**Since:** v1.10.0

**Arguments:**

- ***function (callable)*** - The filter function
- ***collection (array)*** - The array whose values are evaluated

Like the filter function, the reject operation truncates an array based on a boolean predicate. The reject function, however, outputs the values which do not conform to a boolean premise.

```php
const LIST = [12, 13, 19, 15, 22];

$list = A\reject(function ($val) { return $val % 2 == 0; }, LIST);
//outputs [13, 19, 15]
```

## Fold/Reduce function

```
fold/reduce(callable $function, array $collection, mixed $acc)
```

**Since:** v1.5.0

**Arguments:**

- ***function (callable)*** - The fold function
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

### ReduceRight function

**Since:** v1.8.1

**Arguments:**

- ***function (callable)*** - The filter function
- ***collection (array)*** - The array whose values are evaluated
- ***acc (mixed)*** - The accumulator value

Folds an array but does so from right to left.

```php
$collection = ["foo", "bar", "baz"];

$sumOfEven = A\fold(
    function (string $separator, string $val) : string {
        return rtrim($val . $separator, $separator);
    },
    $collection,
    '_'
);
//evaluates to "baz_bar_foo"
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

## intersects function

```
intersects(array $listA, array $listB)
```

**Since:** v1.12.0

**Arguments:**

- ***listX (array)*** - Arrays to be used for comparison

Checks if two arrays have at least one element in common.

```php
$intersects = A\intersects(range(1, 50), range(46, 56));
//outputs true
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

## Every function

```
every(array $array, callable $function)
```

**Since:** v1.8.1

**Arguments**

- ***array (array)*** - The key-value collection
- ***function (callable)*** - The function whose boolean assertion is used

The every function checks if a boolean assertion in a function holds for every value in a list.

```php
$result = A\every(
    [1, 2, 3, 4],
    function ($val) : bool {
        return is_int($val);
    }
);

echo $result; //outputs true
```

## Any function

```
any(array $array, callable $function)
```

**Since:** v1.8.1

**Arguments**

- ***array (array)*** - The key-value collection
- ***function (callable)*** - The function whose boolean assertion is used

The any function, unlike its relative, the every function, checks if a single value in a list conforms to the boolean predicate in a function signature.

```php
$result = A\any(
    [false, true, 1, 2, 3],
    function ($val) : bool {
        return is_bool($val);
    }
);

echo $result; //outputs true
```

## GroupBy function

```
groupBy(array $array, mixed $key)
```

**Since:** v1.8.1

**Arguments**

- ***array (array)*** - The array to sort
- ***key (mixed)*** - The key to use for the grouping

The groupBy function is one that sorts a multi-dimensional array by a defined key. 

```php
$group = A\groupBy(
    [
        ['pos' => 'pg', 'name' => 'dragic'],
        ['pos' => 'sg', 'name' => 'jordan'],
        ['pos' => 'sg', 'name' => 'wade']
    ],
    'pos'
);

var_dump($group); 
//outputs ['pg' => [['pos' => 'pg', 'name' => 'dragic']], 'sg' => [['pos' => 'sg', 'name' => 'jordan'], ['pos' => 'sg', 'name' => 'wade']]]
```

## Where function

```
where(array $list, array $search)
```

**Since:** v1.8.1

**Arguments**

- ***list (array)*** - The array to search
- ***search (array)*** - The list fragment that is the basis for the search

The where function searches a multi-dimensional array using a fragment of a sub-array defined in said multi-dimensional array.

```php
$result = A\where(
    [
        ['pos' => 'pg', 'name' => 'dragic'],
        ['pos' => 'sg', 'name' => 'wade']
    ],
    ['name' => 'dragic']
);

var_dump($result);
//outputs [['pos' => 'pg', 'name' => 'dragic']]
```

## Min function

```
min(array $array)
```

**Since:** v1.8.1

**Arguments**

- ***array (array)*** - The list whose lowest value is to be computed

Finds the lowest value in an array.

```php
$min = A\min([22, 19, 12, 98]);

echo $min; //outputs 12
```

## Max function

```
max(array $array)
```

**Since:** v1.8.1

**Arguments**

- ***array (array)*** - The list whose largest value is to be computed

Finds the largest value in an array.

```php
$max = A\max([22, 19, 98, 12]);

echo $max; //outputs 98
```

## Mean function

```
mean(array $array)
```

**Since:** v1.10.0

**Arguments**

- ***array (array)*** - The list whose mean value is to be computed

Computes the mean of the values in an array.

```php
$mean = A\mean([22, 19, 98, 12]);

echo $mean; //outputs 37.75
```

## Omit function

```
omit(array $array, mixed ...$keys)
```

**Since:** v1.10.0

**Arguments**

- ***array (array)*** - The list to be used for the operation
- ***keys (mixed)*** - The keys to omit from an array

The omit function removes values from an array by key.

```php
$list = A\omit(
    [
        'hbo' => ['game of thrones', 'insecure'],
        'netflix' => ['daredevil', 'luke cage'],
        'amc' => ['breaking bad'],
        'cw' => ['smallville', 'nikita']
    ],
    'amc',
    'cw'
);
//outputs ['hbo' => ['game of thrones', 'insecure'], 'netflix' => ['daredevil', 'luke cage']]
```

## addKeys function

```
addKeys(array $array, mixed ...$keys)
```

**Since:** v1.10.0

**Arguments**

- ***array (array)*** - The list to be used for the operation
- ***keys (mixed)*** - The keys to include

The addKeys function outputs the contents of an array which correspond to specified keys.

```php
const DD_EPISODES = [
    'season_one' => ['Into the ring', 'Cut man', 'Rabbit in a snow Storm'],
    'season_two' => ['Bang', 'Daredevil', 'The Ones we Leave Behind']
];

$list = A\addKeys(DD_EPISODES, 'season_two');
//outputs ['Bang', 'Daredevil', 'The Ones we Leave Behind']
```

## union function

```
union(array ...$list)
```

**Since:** v1.12.0

**Argument(s):**

- ***list (array)*** - The lists to merge

Combines multiple arrays into a single array of unique elements.

```php
$union = A\union(range(1, 5), [4, 3, 99, 48]);
//prints [1, 2, 3, 4, 5, 99, 48]
```

## unionWith function

```
unionWith(callable $function, array ...$list)
```

**Since:** v1.12.0

**Argument(s):**

- ***function (callable)*** - A function whose result is the basis for combining arrays
- ***list (array)*** - The lists to merge

Combines multiple arrays on fulfillment of a condition.

```php
$union = A\unionWith(function (array $num, array $str) : bool {
    return A\isArrayOf($num) == 'integer' && A\isArrayOf($str) == 'string';
}, range(1, 5), ['foo', 'bar']);
//outputs [1, 2, 3, 4, 5, "foo", "bar"]
```