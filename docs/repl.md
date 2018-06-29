---
description: bingo-functional REPL docs
logo: bingo-functional-logo.png
prev: /functors.html
prevTitle: Functors
next: /changes.html
nextTitle: Changes
---

The [bingo-functional console](https://github.com/ace411/bingo-functional-repl) is an appendage of the bingo-functional set of utilities. Capable of parsing idiomatic PHP input, the bingo-functional REPL is one predicated on providing a playground for interaction with the bingo-functional range of functions and functors. 

## Installation

To install the bingo-functional REPL, type the following text in a command line of your choosing:

```
composer require chemem/bingo-functional-repl
```

## Supported Expressions

The bingo-functional console uses the [PHP parser](https://github.com/nikic/PHP-Parser) written by [Nikita Popov](https://github.com/nikic). The premise of the console is extending script-executable bingo-functional functions to the command-line. The console, therefore, supports a limited range of actions listed below:

- the echo statement followed by either a string or number or float

```
bingo-functional> echo "foo"
Result: "foo"
bingo-functional> echo 12
Result: 12
bingo-functional> echo 2.552
Result: 2.552
```

- bingo-functional library-specific calls which can take on single or multiple inline function calls

```
bingo-functional> curry(function ($a, $b) {return $a / $b;})(12)(6)
Result: 2
bingo-functional> map(function ($val) {return $val * 2;}, [1, 2, 3])
Result: [2,4,6]
```

- bingo-functional library monad-specific static expressions which output serialized objects or scalar values upon parsing

```
bingo-functional> State::of(1)->map(function ($a) {return $a + 3;})
Result: <State> [1,4]
bingo-functional> Either::pure(12)->flatMap(function ($a) {return $a * 2;})
Result: 24
```

- constants limited to the help and version directives

```
bingo-functional> version
Result: 1.0.0
```

## Important 

- Semi-colons are not required

- To make the most of the console experience, read the rest of the bingo-functional documentation.