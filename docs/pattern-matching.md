---
logo: bingo-functional-logo.png
description: Pattern Matching docs
prev: /collection.html
prevTitle: Collection Helpers
next: /immutable-lists.html
nextTitle: Immutable Lists
---

# Pattern Matching

The goal of pattern matching is to bind values to successful matches. Pattern matching is similar to the switch statement. The patterns used in the pattern-matching function are a near facsimile of the [Haskell pattern-matching patterns](https://en.wikibooks.org/wiki/Haskell/Pattern_matching). Because pattern matching is a core feature of a language like Haskell, implementing it in PHP is quite the uphill task. The bingo-functional library has two pattern matching functions that conform to the patterns shown in the table below: ```match``` and ```patternMatch```.

| Pattern name    | Format                    | Examples |
|-----------------|---------------------------|----------|
| constant        | A scalar value            | ```12```, ```12.02```, ```"foo"``` |
| variable        | Any value identifier      | ```foo```, ```bar```, ```baz``` |
| array           | [constant, ..., variable] | ```'["foo", "bar", baz]'``` |
| cons            | (identifier:identifier)   | ```(foo:bar:_)``` |
| objects		  | An object				  | ```stdClass::class``` |
| wildcard        | _                         | ```'_'``` |
<br />

The pattern matching subset of the bingo-functional library is quite similar to the [pattern-matching library](https://packagist.org/packages/functional-php/pattern-matching) created by [Gilles Crettenand](https://github.com/krtek4). It is, in fact, inspired by the works of the said individual. 

## match function

```
match(array $patterns)(array $values)
```

**Since:** v1.8.0

**Arguments:**

- ***patterns (array)*** - The patterns to evaluate
- ***values (array)*** - The values for comparison

The match function deals primarily with cons, values separated by a colon. The cons serve as arguments for the accompanying lambdas: each cons pattern has a wildcard before its closing brace.

```php
use Chemem\Bingo\Functional\PatternMatching as PM;

$match = PM\match(
	[
		'(x:xs:_)' => function (int $x, int $xs) { return $x / $xs; },
		'(x:_)' => function (int $x) { return $x * 2; },
		'_' => function () { return 1; }
	]
);

$result = $match([10, 5]);
```

## patternMatch function

```
patternMatch(array $patterns, mixed $values)
```

**Since:** v1.8.1

**Arguments:**

- ***patterns (array)*** - The patterns to evaluate
- ***values (mixed)*** - The values for comparison

The pattern match function is useful for array content comparisons like URL and switch statement-driven matches. The patternMatch function combines arrays, constants, and variables and assesses the specificity of each pattern provided. 

The patternMatch function can detect string matches for single scalar values and evaluate the right function bindings based on value specifics.

```php
use Chemem\Bingo\Functional\PatternMatching as PM;

$scalarMatch = PM\patternMatch(
	[
		'"foo"' => function () { return strtoupper('foo'); },
		'"bar"' => function () { return 'bar'; },
		'_' => function () { return 'undefined'; }
	],
	'foo'
); 
//outputs FOO
```

The patternMatch function's primary feature, the array match is possible for multiple values parsed into an array.

```php
$arrayMatch = PM\patternMatch(
	[
		'["foo", "bar", baz]' => function (string $baz) { 
			return lcfirst(strtoupper($baz)); 
		},
		'["foo", "bar"]' => function () { return strtoupper('foo-bar'); },
		'_' => function () { return 'undefined'; }
	],
	['foo', 'bar', 'functional']
); 
//outputs fUNCTIONAL
```

- Added in version 1.10.0 is the object match feature - convenient for comparing class instances.
- Added in version 1.11.0 is the wildcard match feature. See [issue #12](https://github.com/ace411/bingo-functional/issues/12).

```php
use \Chemem\Bingo\Functional\Functors\Monads\{IO, Reader};

$objectMatch = PM\patternMatch(
	[
		IO::class => function () { return 'IO monad instance'; },
		Reader::class => function () { return 'Reader monad instance'; },
		'_' => function () { return 'unrecognized object'; }
	],
	IO::of(function () { return 12; })
);
//outputs IO monad instance
```

## letIn function

```
letIn(array $keys, array $list)(array $args, callable $operation)
```

**Since:** v1.11.0

**Arguments:**

- ***keys (array)*** - The keys for the deconstruction 
- ***list (array)*** - The list to deconstruct
- ***args (array)*** - The arguments to use in the deconstruction operation
- ***operation (callable)*** - The deconstruction operation

In Elm, it is possible to deconstruct lists (tuples and records) via pattern matching with let-in syntax. An example like the one below is a demonstration of such an operation:

```elm
numbers = 
	( 1, 9, 7, 13 )

let (a, b, c, d) = 
	numbers 
		in 
			a + b + c + d
-- output is 30
```
The result of execution of the code in the snippet above is the integer value ```30```. The let segment creates aliases for the values in the numbers tuple - something akin to the usage of the list directive in PHP. Also, said syntax scopes all the aliases (```a```, ```b```, ```c```, and ```d```) to the operations in the in-section of the code. The bingo-functional implementation of the same snippet is as follows:

```php
$numbers = [1, 9, 7, 13];

$let = PM\letIn(['a', 'b', 'c', 'd'], $numbers);

$in = $let(['a', 'b', 'c', 'd'], function ($a, $b, $c, $d) {
	return $a + $b + $c + $d;
});
```