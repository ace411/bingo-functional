# Change log

## v1.0.0

### Helpers

- compose()
- constantFunction()
- curry()
- curryN()
- extend()
- identity()
- memoize()
- partial()
- pick()
- pluck()
- zip()
- unzip()

### Functors

- Either `Left/Right`
- Maybe `Just/Nothing`
- Applicatives `Applicative/CollectionApplicative`
- Monad `Monad`

## v1.1.0

### New Helper functions

- head()
- tail()
- partition()

## v1.2.0

### New Helper functions

- isArrayOf()
- partialRight()
- partialLeft() as a replacement for partial()

### New Functor features

- TransientMutatorTrait `TransientMutatorTrait`

## v1.2.1

### Fixed the following problem(s)

- the error message shown when a mixed array (array containing more than one type) is supplied to the isArray() function.

- the partialRight() behavior of partialLeft()

## v1.3.0

### Added the following functions to the Monad functor

- filter()
- flatMap()

## v1.4.0

### Made the following change(s)

- the `pluck()`, `pick()`, `isArrayOf()`, and `memoize()` functions have been given callback signatures.

- the `extractErrorMessage()` function and all other related callback functions have been replaced.

- the Monad class has been replaced with new Monads: IO, Reader, Writer, and State.

### New helper functions

- concat()
- throttle()

### New callback functions

- invalidArrayKey()
- invalidArrayValue()
- emptyArray()
- memoizationError()

### New monads

- State monad
- IO monad
- Reader monad
- Writer monad

## v1.5.0

### New Helper functions

- map()
- filter()
- fold()
- reduce()

## v1.6.0

### Made the following change(s)

- Modified the `filter()` function to accurately filter values whenever a boolean predicate is defined.

- Changed parameter order of the return value for the `reduce()` function.

### New Helper Functions

- arrayKeysExist()
- dropLeft()
- dropRight()
- unique()
- flatten()
- compact()

## v1.7.0

### New monad

- ListMonad

## v1.7.1

### Made the following change(s)

- Modified the `throttle()` function to accept multiple arguments

- Added type signatures and doc blocks for functions without any

- Added immutable const definition for `concat()` function

## v1.7.2

### Made the following change(s)

- Modified the `orElse()` methods of the Left, Right, Nothing, and Just functors

- Added the `flatMap()` method to the State and List monads

## v1.8.0

- Added pattern matching to library

### Removed the following callback function(s)

- invalidArrayKey()
- invalidArrayValue()
- emptyArray()
- memoizationError()

### Modified the following function(s)

- map()
- pick()
- fold()
- pluck()
- reduce()
- filter()
- memoize()
- isArrayOf()

### New Helper functions

- fill()
- partial()
- indexOf()
- reverse()
- toPairs()
- fromPairs()
- match()

## v1.9.0

- Added more robust pattern matching to library

### Modified the following functions

- dropLeft()
- dropRight()
- map()
- filter()

### New Helper functions

- every()
- any()
- where()
- reduceRight()
- foldRight()
- min()
- max()
- groupBy()
- patternMatch()

## v1.10.0

- Added [immutable collections](https://medium.com/@SkillzMic/about-the-immutable-collections-i-added-to-bingo-functional-700be1790a37)

- Added object matching capability to patternMatch

- Modified patternMatch array matching to give more concise match results

- Jettisoned reverse function

### New Helper functions

- mapDeep()
- omit()
- addKeys()
- last()
- reject()
- mean()

## Modified the following functions

- patternMatch()

## v1.11.0

- Modified pattern matching algorithm to enable usage of wildcards in patterns

- Modified State, List, Writer, and Reader monads

- Added monad helper functions

- Added Applicative helper functions

- Added `bind` and `of` methods to Either and Maybe type classes

- Added flip helper function

- Added `liftIn` function

### New Applicative Helper functions

- Applicative\pure()

- Applicative\liftA2()

### New Monadic Helper functions

- mcompose()

- bind()

- IO\IO

- IO_print()

- IO\getChar()

- IO\putChar()

- IO\putStr()

- IO\getLine()

- IO\interact()

- IO\readFile()

- IO\writeFile()

- IO\appendFile()

- IO\readIO()

- State\state()

- State\gets()

- State\modify()

- State\evalState()

- State\execState()

- State\put()

- State\runState()

- ListMonad\fromValue()

- ListMonad\concat()

- ListMonad\prepend()

- LIstMonad\append()

- ListMonad\head()

- ListMonad\tail()

- Reader\reader()

- Reader\runReader()

- Reader\mapReader()

- Reader\withReader()

- Reader\ask()

- Writer\writer()

- Writer\runWriter()

- Writer\execWriter()

- Writer\mapWriter()

### New union type helper functions

- Either\either()

- Either\isLeft()

- Either\isRight()

- Either\lefts()

- Either\rights()

- Either\fromLeft()

- Either\partitionEithers()

- Maybe\maybe()

- Maybe\isJust()

- Maybe\isNothing()

- Maybe\fromJust()

- Maybe\fromNothing()

- Maybe\maybeToList()

- Maybe\listToMaybe()

- Maybe\catMaybes()

- Maybe\mapMaybe()

## v1.12.0

- Removed function parameter from `zip` function

- Created `Monadic` interface for Monads

- Added new helper functions

- Added new Monad helper functions

- Added [APCU](https://php.net/apcu)-supported functionality to memoize function

- Added constant static function definitions for `Monadic` types

- Added new `Collection` functions

### New Helper functions

- toWords()

- slugify()

- truncate()

- intersects()

- composeRight()

- filePath()

- union()

- unionWith()

- zipWith()

### New Monadic Helper functions

- filterM()

- foldM()

### New Collection functions

- fetch()

- contains()

- unique()

- head()

- tail()

- last()

- intersects()

- implode()

- offsetGet()

## v1.13.0

- Modified `putStr`, `getLine`, `putStrLn`, `putChar` IO helper functions

- Added default values to `pick` and `pluck` functions

- Added internal functions namespaced under `Chemem\Bingo\Functional\Algorithms\Internal`

- Modified some list/collection primitives to work on objects as well as hashtables

- Infused Collection with Transient properties

- Added `mergeN()` Collection method

- Modified `any()` and `every()` Collection methods

- Added `ImmutableDataStructure` and `ImmutableList` interfaces

- Added a Tuple immutable structure

- Added `mapM()` Monad function

- Replaced original pattern-matching algorithm with that in the [`functional-php/pattern-matching`](https://github.com/functional-php/pattern-matching) library

- Added new helper functions

- Jettisoned docs folder. Moved docs site to [new address](https://bingo-functional-docs.now.sh/)

### New Helper Functions

- intersperse()

- difference()

- countOfKey()

- countOfValue()

- renameKeys()

### New Monadic Helper functions

- mapM()

### Modified functions

- map()

- filter()

- fold()

- reject()

- pluck()

- pick()

- any()

- every()

- partial()

- indexOf()

- indexesOf()

- addKeys()

- omit()

- partialRight()

- dropLeft()

- dropRight()

- mapDeep()

- filterDeep()

## v1.14.0

- Modified functions

- Modified pattern matching primitives

  - Added internal functions namespaced under `Chemem\Bingo\Functional\PatternMatching\Internal`

- Removed functions

- Added lenses

- Modified List and Writer monads

- Added `Functor`, `Monad`, and `Applicable` interfaces

- Modified `intersects()` function on immutable Collection

- Revamped project test suite

  - Split Algorithm tests into individual files

  - Replaced Monad, Applicative, and Immutable tests with Eris-powered fuzzing

  - Added Functor, Applicative, and Monad law evaluations

### Modified Monadic functions

- ListMonad\head()

- ListMonad\tail()

- IO\getChar()

- IO\putChar()

- IO\putStr()

- IO\getLine()

### Deleted functions

- IO\readIO()

- Reader\ask()

### Modified functions

- patternMatch()

- match()

- compact()

- keysExist()

- reject()

- renameKeys()

- max()

- min()

- firstIndexOf()

- fill()

- every()

- compact()

- mean()

- intersects()

- tail()

- zip()

### New functions

- Lens\lensPath()

- Lens\lensKey()

- Lens\over()

- Lens\view()

- Lens\set()

- Lens\lens()
