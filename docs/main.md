---
title: install
subTitle: Installation of library
---

The bingo-functional library is a functional programming library built in PHP for PHP users. Available in this library are monads, Just/Nothing types, Left/Right types, applicative functors, and function algorithms meant to ease the cognitive burden for those who intend to use them. The subsequent text is documentation of the library which should help you, the reader, understand how to go about using it.

## Installation

Before you can use the bingo-functional library, you should have either Git or Composer installed on your system of preference. To install the package via Composer, type the following in your preferred command line interface:

```
composer require chemem/bingo-functional
```

To install this without Composer, type:

```
git clone https://github.com/ace411/bingo-functional.git
```

Then Adding the ```autoload.php``` before calling this package classes or functions.

```
require_once './autoload.php';
```

## Usage

The bingo-functional library's utilities are namespaced. Below is a listing of all the package's offerings and their respective namespaces:

| Utility                    | Namespace |
|----------------------------|----------------------------------------------------------|
| Helper Functions           | ```Chemem\Bingo\Functional\Algorithms\```                |
| Monads                     | ```Chemem\Bingo\Functional\Functors\Monads\```           |
| Applicatives               | ```Chemem\Bingo\Functional\Functors\Applicatives\```     |
| Union Types                | ```Chemem\Bingo\Functional\Functors\{Either or Maybe}``` | 
| Pattern Matching Functions | ```Chemem\Bingo\Functional\PatternMatching\```           |