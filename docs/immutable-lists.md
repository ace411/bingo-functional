# Immutable Lists

An immutable collection is a data structure which is convenient for functional programming because it is [inherently persistent](https://en.wikipedia.org/wiki/Persistent_data_structure). Persistence implies creating (sometimes almost churning out) new copies of an immutable state - this is especially important for graceful mutation.

The [ad-hoc polymorphism](https://en.wikipedia.org/wiki/Ad_hoc_polymorphism) of the Collection class is an enabler of controlled state transition - the ethos of functional programming. The internal structure of the Collections class is such that an [SPL fixed array](http://php.net/manual/en/class.splfixedarray.php) is used to store list items. Below is a detailed enumeration of the class' methods.

## from

```
Collection::from(array $items)
```

**Argument(s)**

- ***items (array)*** - The items to store

The static method, from, creates an immutable list. It is a variadic function, so, the spread operator is necessary for arrays.

```php
use Chemem\Bingo\Functional\Immutable\Collection;

$fromArray = Collection::from([1, 2, 3]); //array spread syntax
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
    ->map(function (int $val) : int { 
        return $val * 2; 
    }); 
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
    ->flatMap(function (int $val) : int { 
        return $val + 1; 
    }); 
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
$list = Collection::from([12, 13, 15, 19, 24])
    ->filter(function (int $val) : bool { 
        return $val % 2 == 0; 
    }); 
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
$list = Collection::from([1, 2, 3, 4])
    ->fold(function (string $acc, string $val) { 
        return $val + $acc; 
    }, 1);
//outputs the value 11
```

## merge

```
$list->merge(Collection $list)
```

**Argument(s)**

- ***list (Collection)*** - The list to merge with 

The merge function combines two lists.

```php
$even = Collection::from(['foo', 'bar']);

$odd = Collection::from(['baz', 'foo-bar']);

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
$list = Collection::from(['foo', 'bar', 1, 2, 3])
    ->slice(2); //outputs the collection [1, 2, 3]
```

## fill

```
$list->fill(mixed $value, int $start, int $end)
```

**Argument(s)**

- ***value (mixed)*** - The value to insert in list
- ***start (int)*** - The first index whose corresponding value is to be replaced with fill value
- ***end (int)*** - The last index whose corresponding value is to be replaced with fill value

The fill function replaces the values of specified list indexes with an arbitrary value.

```php
$list = Collection::from(range(1, 10))
    ->fill('foo', 2, 4);
//outputs the collection [1, 2, 'foo', 'foo', 'foo', 6, 7, 8, 9, 10]
```

## fetch

```
$list->fetch(mixed $key)
```

**Since:** v1.12.0

**Argument(s)**

- ***key (mixed)*** - The key on which the search is based

Fetch all the values which correspond to a specified key.

```php
$collection = Collection::from([
    ['id' => 35, 'name' => 'Durant'],
    ['id' => 24, 'name' => 'Bryant']
]);

print_r($collection->fetch('name'));
```

## contains
```
$list->contains(mixed $value)
```

**Since:** v1.12.0

**Argument(s):** 

- ***value (mixed)*** - The value whose existence is examinable

Checks if a value exists in a collection. Akin to the [key_exists](https://secure.php.net/manual/en/function.key-exists.php) function.

```php
$contains = Collection::from([
    ['id' => 3, 'name' => 'Wade'],
    ['id' => 23, 'name' => 'Mike']
])->contains('name'); //returns true
```

## offsetGet
```
$list->offsetGet(int $offset);
```
**Since:** v1.12.0

**Argument(s):**

- ***offset (integer)*** - The numerical key with a unique data value binding

Returns a value which corresponds to a specified numerical key.

```php
$val = Collection::from(range(1, 5))->offsetGet(2);
//outputs 3
```

## unique
```
$list->unique();
```

**Since:** v1.12.0

**Argument(s):**

> None

Analogous to the [unique](/collection?id=unique-function) function.

```php
$list = Collection::from(range(1, 3))
    ->merge(Collection::from(range(2, 5)))
    ->unique();
//outputs the Collection [1, 2, 3, 4, 5]
```

## head
```
$list->head();
```

**Since:** v1.12.0

**Argument(s):**

> None

Analogous to the [head](/collection?id=head-function) function

```php
$arr = range(1, 5);
$head = Collection::from($arr)->head();
```

## tail
```
$list->tail();
```

**Since:** v1.12.0

**Argument(s):**

> None

Analogous to the [tail](/collection?id=tail-function) function.

```php
$tail = Collection::from($arr)->tail();
//outputs the Collection [2, 3, 4, 5]
```

## last
```
$list->last();
```

**Since:** v1.12.0

**Argument(s):**

> None

Analogous to the [last](/collection?id=last-function) function.

```php
$last = Collection::from($arr)->last(); //returns 5
```

## intersects
```
$list->intersects(Collection $list);
```

**Since:** v1.12.0

**Argument(s):**

- ***list (Collection)*** - The list to compare values with

Analogous to the [intersects](/collection?id=intersects-function) function.

```php
$intersects = Collection::from(range(1, 3))
    ->intersects(Collection::from(range(5, 7)));
//returns false
```

## implode
```
$list->implode(string $delimiter);
```

**Since:** v1.12.0

**Argument(s):**

- ***delimiter (string)*** - The string to insert between elements

Joins Collection elements with a string. Analogous to the [implode](https://secure.php.net/manual/en/function.implode.php) function.

```php
$str = Collection::from(['Mike', 'is', 'the', 'GOAT'])->implode(' ');
//prints "Mike is the GOAT"
```

## toArray

```
$list->toArray()
```

**Argument(s)** - none

The toArray method converts the collection to an array.

```php
$list = Collection::from(['foo', 'bar'])
    ->map('strtoupper')
    ->toArray(); //outputs the array ['FOO', 'BAR']
```

# Important

The collection class implements the ```Countable```, ```JsonSerializable```, and ```IteratorAggregate``` interfaces. The implication is that bingo-functional's immutable collections are compatible with ```count()```, ```json_encode()```, and idiomatic PHP recursion constructs such as ```for``` and ```foreach```.

```php
$list = Collection::from(['foo', 'bar', 'baz']);

echo count($list); //outputs 3

echo json_encode($list); //outputs '["foo", "bar", "baz"]'

foreach ($list as $val) {
    echo $val; //outputs foo, bar, and then baz
}
```