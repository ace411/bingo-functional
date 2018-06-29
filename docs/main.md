---
title: install
description: Installation of library
next: functions.html
nextTitle: Function helpers
---
<img src="bingo-functional-logo.png" alt="bingo-functional logo">

<div style="display: inline-flex; flex-flow: row; height: 20px; flex-wrap: nowrap; margin: 0; padding: 0;">
    <img alt="Chat on Gitter" style="max-width: 105px; margin-right: 2px;" onClick="location.href='https://gitter.im/bingo-functional/Lobby'" src="https://badges.gitter.im/bingo-functional/Lobby.svg">
    <img alt="Build Status" style="max-width: 105px; margin-left: 2px;" onClick="location.href='https://travis-ci.org/ace411/bingo-functional'" src="https://travis-ci.org/ace411/bingo-functional.svg?branch=master" />
    <img alt="Codacy Badge" style="max-width: 105px; margin-left: 2px;" onClick="location.href='https://www.codacy.com/app/ace411/bingo-functional?utm_source=github.com&utm_medium=referral&utm_content=ace411/bingo-functional&utm_campaign=badger'" src="https://api.codacy.com/project/badge/Grade/7c30c744fd0142d58dd210fd961ea842">
    <img alt="Codecov" style="max-width: 105px; margin-left: 2px;" onClick="location.href='https://codecov.io/gh/ace411/bingo-functional'" src="https://codecov.io/gh/ace411/bingo-functional/branch/master/graph/badge.svg">
    <img alt="Latest Stable Version" style="max-width: 105px; margin-left: 2px;" onClick="location.href='https://packagist.org/packages/chemem/bingo-functional'" src="https://poser.pugx.org/chemem/bingo-functional/v/stable">
    <img alt="License" style="max-width: 105px; margin-left: 2px;" onClick="location.href='https://packagist.org/packages/chemem/bingo-functional'" src="https://poser.pugx.org/chemem/bingo-functional/license">
    <img alt="Total Downloads" style="max-width: 105px; margin-left: 2px;" onClick="location.href='https://packagist.org/packages/chemem/bingo-functional'" src="https://poser.pugx.org/chemem/bingo-functional/downloads">
    <img alt="Twitter" style="max-width: 105px; margin-left: 2px;" onClick="location.href='https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2Face411%2Fbingo-functional'" src="https://img.shields.io/twitter/url/https/github.com/ace411/bingo-functional.svg?style=social">
</div>

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
