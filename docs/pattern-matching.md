---
title: pattern-matching
subTitle: Pattern Matching docs
---

The goal of pattern matching is to bind values to successful matches. Pattern matching is similar to the switch statement. The patterns used in the pattern-matching function are a near facsimile of the [Haskell pattern-matching patterns](https://en.wikibooks.org/wiki/Haskell/Pattern_matching). Because pattern matching is a core feature of a language like Haskell, implementing it in PHP is quite the uphill task. The bingo-functional library has two pattern matching functions that conform to the patterns shown in the table below: match and patternMatch.

| Pattern name | Format | Examples |
|--------------|:------:|---------:|
| constant     | A scalar value | 12, 12.02, "foo" |
| variable     | Any value identifier | foo, bar, baz |
| array        | [constant, ..., variable] | '["foo", "bar", baz]' |
| cons         | (identifier:identifier)   | (foo:bar:_) |
| wildcard (mandatory default option)     | _  | '_' |


The pattern matching subset of the bingo-functional library is quite similar to the [pattern-matching library](https://packagist.org/packages/functional-php/pattern-matching) created by [Gilles Crettenand](https://github.com/krtek4). It is, in fact, inspired by the works of the said individual. 

## match function

```
match(array $patterns, array $values)
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
		'(x:xs:_)' => function (int $x, int $xs) {
			return $x / $xs;
		},
		'(x:_)' => function (int $x) {
			return $x * 2;
		},
		'_' => function () {
			return 1;
		}
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
		'"foo"' => function () {
			$val = strtoupper('foo');
			
			return $val;
		},
		'"bar"' => function () {
			return 'bar';
		},
		'_' => function () {
			return 'undefined';
		}
	],
	'foo'
);
```

The patternMatch function's primary feature, the array match is possible for multiple values parsed into an array.

```php
$arrayMatch = PM\patternMatch(
	[
		'["foo", "bar", baz]' => function (string $baz) {
			$val = lcfirst(strtoupper($baz));
			
			return $val;
		},
		'["foo", "bar"]' => function () {
			$val = strtoupper('foo-bar');
			
			return $val;
		},
		'_' => function () {
			return 'undefined';
		}
	],
	['foo', 'bar', 'functional']
);
```