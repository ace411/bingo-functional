---
logo: bingo-functional-logo.png
description: Documentation for Immutable Collections
prev: /pattern-matching.html
prevTitle: Pattern Matching
next: /functors.html
nextTitle: Functors
---

# Immutable Lists

An immutable collection is a data structure which is convenient for functional programming because it is [inherently persistent](https://en.wikipedia.org/wiki/Persistent_data_structure). Persistence implies state maintenance - this is especially important for graceful mutation.

The [ad-hoc polymorphism](https://en.wikipedia.org/wiki/Ad_hoc_polymorphism) of the Collection class is an enabler of controlled state transition - the ethos of functional programming. The internal structure of the Collections class is such that an [SPL fixed array](http://php.net/manual/en/class.splfixedarray.php) is used to store list items. Below is a detailed enumeration of the class' methods.

## from

```
Collection::from(mixed ...$items)
```

**Argument(s)**

- ***items (mixed)*** - The items to store

The static method, from, creates an immutable list. It is a variadic function, so, the spread operator is necessary for arrays.

```php
use Chemem\Bingo\Functional\Immutable\Collection;

$list = Collection::from(1, 2, 3); //non-array syntax

$fromArray = Collection::from(...[1, 2, 3]); //array spread syntax
```

## map

```
$list->map(callable $function)
```

**Argument(s)**

- ***function (callable)*** - The function to apply to each list item

The map method applies a function to each item in the list.

```php
$list = Collection::from(1, 2, 3)
    ->map(function (int $val) : int { return $val * 2; }); 
//outputs the collection [2, 4, 6]
```

## flatMap

```
$list->flatMap(callable $function)
```

**Argument(s)**

- ***function (callable)*** - The function to apply to each list item

The flatMap method, like the map method, iteratively applies a function to items in a list but evaluates to an array and not a Collection object.

```php
$list = Collection::from(1, 2, 3, 4)
    ->flatMap(function (int $val) : int { return $val + 1; }); 
//outputs the array [2, 3, 4, 5]
```

## filter

```
$list->filter(callable $function)
```

**Argument(s)**

- ***function (callable)*** - The function to use to filter the list

The filter function generates a list whose values conform to a boolean predicate.

```php
$list = Collection::from(12, 13, 15, 19, 24)
    ->filter(function (int $val) : bool { return $val % 2 == 0; }); 
//outputs the collection [12, 24]
```

## fold

```
$list->fold(callable $function, mixed $acc)
```

**Argument(s)**

- ***function (callable)*** - The fold function (has an arity of 2)
- ***acc (mixed)*** - The accumulator value

The fold function transforms a list into a single value. 

```php
$list = Collection::from(...[1, 2, 3, 4])
    ->fold(function (string $acc, string $val) { return $val + $acc; }, 1);
//outputs the collection [11]
```

## merge

```
$list->merge(Collection $list)
```

**Argument(s)**

- ***list (Collection)*** - The list to merge with 

The merge function combines two lists.

```php
$even = Collection::from('foo', 'bar');

$odd = Collection::from(...['baz', 'foo-bar']);

$even->merge($odd); //outputs the collection ['foo', 'bar', 'baz', 'foo-bar']
```

## slice

```
$list->slice(int $count)
```

**Argument(s)**

- ***count (int)*** - The number of items to remove from list

The slice method removes a specified number of items from a list.

```php
$list = Collection::from('foo', 'bar', 1, 2, 3)
    ->slice(2); //outputs the collection [1, 2, 3]
```

## toArray

```
$list->toArray()
```

**Argument(s)** - none

The toArray method converts the collection to an array.

```php
$list = Collection::from('foo', 'bar')
    ->map('strtoupper')
    ->toArray(); //outputs the array ['FOO', 'BAR']
```

# Important

The collection class implements the ```Countable```, ```JsonSerializable```, and ```IteratorAggregate``` interfaces. The implication is that bingo-functional's immutable collections are compatible with ```count()```, ```json_encode()```, and idiomatic PHP recursion constructs such as ```for``` and ```foreach```.

```php
$list = Collection::from('foo', 'bar', 'baz');

echo count($list); //outputs 2

echo json_encode($list); //outputs '["foo", "bar", "baz"]'

foreach ($list as $val) {
    echo $val; //outputs foo, bar, and then baz
}
```