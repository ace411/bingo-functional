# String Helpers

The following enumeration is a list of functions whose purpose is string manipulation.

## truncate

```
truncate(string $text, int $limit)
```

**Since:** v1.12.0

**Arguments:**

- ***text (string)*** - The text to truncate
- ***limit (integer)*** - Arbitrary number of characters to include

Outputs an arbitrary number of characters in a string and appends an ellipsis to the resultant string.

```php
const TEXT = 'Culpa exercitation nostrud dolor est voluptate velit amet qui eiusmod amet et est velit.';

$truncate = A\truncate(TEXT, 18); 
//prints Culpa exercitation...
```

## toWords

```
toWords(string $text, string $regex)
```

**Since:** v1.12.0

**Arguments:**

- ***text (string)*** - The text to split into words
- ***regex (string)*** - The regex which serves as the rubric for splitting the text

Splits a string into an array of words.

```php
const TEXT = 'Culpa irure eu occaecat dolor.';

$words = A\toWords(TEXT, '/[\s]+/'); //prints ['Culpa', 'irure', 'eu', 'occaecat', 'dolor']
```

## slugify

```
slugify(string $text)
```

**Since:** v1.12.0

**Arguments:**

- ***text (string)*** - The text to convert to a slug

Converts a string to a [slug](https://prettylinks.com/2018/03/url-slugs/).

```php
$slugified = A\slugify('lorem ipsum'); //prints lorem-ipsum
```

## concat

```
concat(string $wildcard, string ...strings)
```

**Since:** v1.4.0

**Arguments:**

- ***wildcard (string)*** - The wildcard to be used
- ***strings (string)*** - The strings to concatenate

The concat() function concatenates strings. It appends strings onto each other sequentially. It requires a wildcard separator though.

```php 
$wildcard = ' ';

echo A\concat($wildcard, 'Kampala', 'is', 'hot');
//should print 'Kampala is hot'
```

## filePath

```
filePath(int $level, string ...$component)
```

**Since:** v1.12.0

**Arguments:**

- ***level (int)*** - Directory level relative to a project's root directory
- ***component (string)*** - Fragment of a file path

Outputs an absolute path to a file/directory.

```php
$path = A\filePath(0, 'path', 'to', 'file'); 
//prints __DIR__ . '/path/to/file'
```