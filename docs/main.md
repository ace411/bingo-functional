[![Join the chat at https://gitter.im/bingo-functional/Lobby](https://badges.gitter.im/bingo-functional/Lobby.svg)](https://gitter.im/bingo-functional/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/7c30c744fd0142d58dd210fd961ea842)](https://www.codacy.com/app/ace411/bingo-functional?utm_source=github.com&utm_medium=referral&utm_content=ace411/bingo-functional&utm_campaign=badger)
[![Build Status](https://travis-ci.org/ace411/bingo-functional.svg?branch=master)](https://travis-ci.org/ace411/bingo-functional)
[![codecov](https://codecov.io/gh/ace411/bingo-functional/branch/master/graph/badge.svg)](https://codecov.io/gh/ace411/bingo-functional)
[![Latest Stable Version](https://poser.pugx.org/chemem/bingo-functional/v/stable)](https://packagist.org/packages/chemem/bingo-functional)
[![License](https://poser.pugx.org/chemem/bingo-functional/license)](https://packagist.org/packages/chemem/bingo-functional)
[![Total Downloads](https://poser.pugx.org/chemem/bingo-functional/downloads)](https://packagist.org/packages/chemem/bingo-functional)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/ace411/bingo-functional.svg?style=social)](https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2Face411%2Fbingo-functional)

The bingo-functional library is a functional programming library built in PHP for PHP users. Available in this library are monads, Just/Nothing types, Left/Right types, applicative functors, and function algorithms meant to ease the cognitive burden for those who intend to use them. The subsequent text is documentation of the library which should help you, the reader, understand how to go about using it.

## Installation

Before you can use the bingo-functional library, you should have either Git or Composer installed on your system of preference. To install the package via Composer, type the following in your preferred command line interface:

```
composer require chemem/bingo-functional
```

To install via Git - without Composer, type:

```
git clone https://github.com/ace411/bingo-functional.git
```

Upon successful installation, add the following statement to the summit of all the scripts in which you intend to use the library's functions and functors.

```php
require_once __DIR__ . '/autoload.php';
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
| Immutable Collections      | ```Chemem\Bingo\Functional\Immutable\Collection\```       |

Recently, I have been working on a book which puts this library at the forefront of many explanations of functional programming in PHP. I advise that you, a visitor of this site and prospective user of the bingo-functional library, consider purchasing the volume currently retailing on [Leanpub](https://leanpub.com/functionalprogramminginphp).

<p align="center">
    <img src="https://s3.amazonaws.com/titlepages.leanpub.com/functionalprogramminginphp/hero?1540289375" onClick="location.href='https://leanpub.com/functionalprogramminginphp'" style="cursor:hover;" height="480">
</p>  

## Ownership

Built by [Lochemem Bruno Michael](https://github.com/ace411) and licensed under <strong>Apache-2.0</strong>