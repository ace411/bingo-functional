[![Join the chat at https://gitter.im/bingo-functional/Lobby](https://badges.gitter.im/bingo-functional/Lobby.svg)](https://gitter.im/bingo-functional/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/7c30c744fd0142d58dd210fd961ea842)](https://www.codacy.com/app/ace411/bingo-functional?utm_source=github.com&utm_medium=referral&utm_content=ace411/bingo-functional&utm_campaign=badger)
[![Build Status](https://travis-ci.org/ace411/bingo-functional.svg?branch=master)](https://travis-ci.org/ace411/bingo-functional)
[![codecov](https://codecov.io/gh/ace411/bingo-functional/branch/master/graph/badge.svg)](https://codecov.io/gh/ace411/bingo-functional)
[![Latest Stable Version](https://poser.pugx.org/chemem/bingo-functional/v/stable)](https://packagist.org/packages/chemem/bingo-functional)
[![License](https://poser.pugx.org/chemem/bingo-functional/license)](https://packagist.org/packages/chemem/bingo-functional)
[![Total Downloads](https://poser.pugx.org/chemem/bingo-functional/downloads)](https://packagist.org/packages/chemem/bingo-functional)
[![Monthly Downloads](https://poser.pugx.org/chemem/bingo-functional/d/monthly)](https://packagist.org/packages/chemem/bingo-functional)
[![composer.lock](https://poser.pugx.org/chemem/bingo-functional/composerlock)](https://packagist.org/packages/chemem/bingo-functional)
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

I published a book titled Functional Programming in PHP that `bingo-functional` features prominently in. I advise that you, a visitor of this site and prospective user of the bingo-functional library, consider purchasing the volume currently retailing on [Leanpub](https://leanpub.com/functionalprogramminginphp).

<p align="center">
    <img src="https://s3.amazonaws.com/titlepages.leanpub.com/functionalprogramminginphp/hero?1540289375" onClick="location.href='https://leanpub.com/functionalprogramminginphp'" style="cursor:hover;" height="480">
</p>

<style>.bmc-button img{width: 35px !important;margin-bottom: 1px !important;box-shadow: none !important;border: none !important;vertical-align: middle !important;}.bmc-button{padding: 7px 5px 7px 10px !important;line-height: 35px !important;height:51px !important;min-width:217px !important;text-decoration: none !important;display:inline-flex !important;color:#000000 !important;background-color:#FFFFFF !important;border-radius: 5px !important;border: 1px solid transparent !important;padding: 7px 5px 7px 10px !important;font-size: 20px !important;letter-spacing:-0.08px !important;box-shadow: 0px 1px 2px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;margin: 0 auto !important;font-family:'Lato', sans-serif !important;-webkit-box-sizing: border-box !important;box-sizing: border-box !important;-o-transition: 0.3s all linear !important;-webkit-transition: 0.3s all linear !important;-moz-transition: 0.3s all linear !important;-ms-transition: 0.3s all linear !important;transition: 0.3s all linear !important;}.bmc-button:hover, .bmc-button:active, .bmc-button:focus {-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;text-decoration: none !important;box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;opacity: 0.85 !important;color:#000000 !important;}</style><link href="https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext" rel="stylesheet"><a class="bmc-button" target="_blank" href="https://www.buymeacoffee.com/agiroLoki"><img src="https://cdn.buymeacoffee.com/buttons/bmc-new-btn-logo.svg" alt="Buy me a coffee"><span style="margin-left:15px;font-size:19px !important;">Buy me a coffee</span></a>

## Ownership

Built by [Lochemem Bruno Michael](https://github.com/ace411) and licensed under <strong>Apache-2.0</strong>