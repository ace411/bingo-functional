# Getting Started

## About

The bingo-functional libraries are suites of Functional Programming utilities. Available in the said packages are helper functions - `compose()`, `map()`, `filter()`, `fold()` and such, pattern matching utilities, functors, and monads - meant to ease the cognitive burden for those who intend to use them. The subsequent text provides elucidatory material for the libraries which should help you, the reader, understand how to go about using them.

## Installation

Before you can use any of the bingo-functional libraries, you should have one of either Composer, Yarn, NPM, or Git installed on your system of preference. Shown below are the respective installation directives for the aforestated options.

{% tabs %}
{% tab title="PHP" %}
```
$ composer require chemem/bingo-functional
```
{% endtab %}

{% tab title="JavaScript" %}
```
$ yarn add bingo-functional-js
```
{% endtab %}

{% tab title="Git" %}
```
$ git clone https://github.com/ace411/<library>.git
```
{% endtab %}
{% endtabs %}

### Basic Usage

Upon successful installation of the packages via any one of the options shown in the preceding text, you can operationalize library artifacts by invoking them in your code. The following are examples of usage in PHP and JavaScript environments.

{% tabs %}
{% tab title="PHP" %}
```php
use Chemem\Bingo\Functional as f;

$x = f\identity(2);
```
{% endtab %}

{% tab title="JavaScript" %}
```javascript
import { identity } from 'bingo-functional-js'

let x = identity(2);
```
{% endtab %}
{% endtabs %}

{% hint style="info" %}
The PHP library's utilities are namespaced.
{% endhint %}

## Additional Material

I published a book titled Functional Programming in PHP that this library features prominently in. I advise that you, a visitor of this site and prospective user of the library, consider purchasing the volume currently retailing on [Leanpub](https://leanpub.com/functionalprogramminginphp).



![](https://s3.amazonaws.com/titlepages.leanpub.com/functionalprogramminginphp/hero?1540289375)

{% hint style="info" %}
`bingo-functional, bingo-functional-js,` and `bingo-functional-repl` are the works of [Lochemem Bruno Michael](https://github.com/ace411) and are licensed under **Apache-2.0**.
{% endhint %}

