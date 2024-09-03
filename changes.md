# bingo-functional changes

## v2.4.0

- Added `jsonDecode` and `extract` functions
- Reworked internals of `partition`, `slugify`, and `partitionBy` functions
- Infused `startsWith`, `endsWith`, `contains`, and `truncate` functions with multi-byte string processing capabilities
- Added opt-in key propagation to `filter`, and `reject` functions
- Added [ext-eio](https://pecl.php.net/eio)-powered non-blocking file operations for IO monad
- Replaced pattern matching parser in `functional-php/pattern-matching` with custom parser
- Replaced cons matching function calls in `cmatch` with custom parser

## v2.3.0

- Added `keys`, `values`, and `size` functions
- Altered file topology in source code directories
- Created separate entry points for library artifacts
- Added [`ext-ds` Vector](https://www.php.net/manual/en/class.ds-vector.php) support to `Chemem\Bingo\Functional\Immutable\Collection`
- Infused `extend`, `dropLeft`, `dropRight`, `flatten`, `filterM`, `filterDeep`, `foldM`, `mapM`, `mapMaybe`, `mapDeep`, `partition`, `partitionBy`, `partitionEithers`, `lefts`, `rights`, `foldRight`, `reduceRight`, `fromPairs`, `isArrayOf`, `head`, `last`, `unique`, `flatten`, `union`, `unionWith`, `zip`, `zipWith` functions with object processing capabilities
- Fixed anomalous `assocPath` function behavior
- Added dot notation-encoded path parsing to `pluckPath` and `assocPath` functions
- Enforced optional interoperability with `ext-mbstring` in the signatures of `startsWith` and `endsWith`
- Conditioned subsumption of errors in `readFile`, `writeFile`, and `appendFile` functions in an `IOException`
- Added workarounds for the deprecation of the use of `end` and `reset` - on objects in PHP 8.1 or newer - in `head` and `last` functions

## v2.2.0

- Added `equals` and `path` helper functions
- Added default parameters to `head` and `last` functions
- Added `_refobj` internal function for object comparisons
- Improved `memoize` function amenability to `igbinary` and `apcu` extensions

## v2.1.0

- Added `page` function
- Fixed erroneous namespace in `last` function
- Added `kleisli` composition function

## v2.0.1

- Modified `cmatch` function internals to better handle wildcard patterns

## v2.0.0

- Renamed namespace `Chemem\Bingo\Functional\Algorithms` to `Chemem\Bingo\Functional`
- Moved `Maybe` and `Either` monad artifacts into `Chemem\Bingo\Functional\Functors\Monads` namespace
- Modified `patternMatch`, `cmatch`, `compact`, `keysExist`, `reject`, `max`, `min`, `firstIndexOf`, `fill`, `every`, `compact`, `mean`, `intersects`, `tail`, `zip` helper functions
- Modified pattern matching primitives namespaced under `Chemem\Bingo\Functional\PatternMatching\Internal`
- Removed `readIO`, `ask`, `Maybe::lift`, `Either::lift` functions
- Added lenses
- Added transducer functions
- Modified List and Writer monads
- Added `Functor`, `ApplicativeFunctor`, and `Monad` interfaces
- Modified `intersects` function in immutable `Collection`
- Renamed `match` to `cmatch`
- Added `liftM` monad helper function
- Added `K` function (K-combinator)
- Revamped project test suite

## v1.13.0

- Modified `putStr`, `getLine`, `putStrLn`, `putChar` IO helper functions
- Added default values to `pick` and `pluck` functions
- Added internal functions namespaced under `Chemem\Bingo\Functional\Algorithms\Internal`
- Modified some list/collection primitives to work on objects as well as hashtables
- Infused Collection with `Transient` properties
- Added `mergeN` Collection method
- Modified `any` and `every` Collection methods
- Added `ImmutableDataStructure` and `ImmutableList` interfaces
- Added a Tuple immutable structure
- Added `mapM` Monad function
- Modified `map`, `filter`, `fold`, `reject`, `pluck`, `pick`, `any`, `every`, `partial`, `indexOf`, `indexesOf`, `addKeys`, `omit`, `partialRight`, `dropLeft`, `dropRight`, `mapDeep`, and `filterDeep` helper functions
- Replaced original pattern-matching algorithm with that in the [functional-php/pattern-matching](https://github.com/functional-php/pattern-matching) library
- Added `intersperse`, `difference`, `countOfKey`, `countOfValue`, and `renameKeys` functions
- Jettisoned docs folder. Moved docs site to new address

## v1.12.0

- Removed function parameter from zip function
- Created Monadic interface for Monads
- Added `toWords`, `slugify`, `truncate`, `intersects`, `composeRight`, `filePath`, `union`, `unionWith`, and `zipWith` helper functions
- Added `filterM` and `foldM` Monad helper functions
- Added APCU-supported functionality to memoize function
- Added constant static function definitions for Monadic types
- Added `fetch`, `contains`, `unique`, `head`, `tail`, `last`, `intersects`, `implode`, and `offsetGet` Collection functions

## v1.11.0

- Modified pattern matching algorithm to enable usage of wildcards in patterns
- Modified `State`, `List`, `Writer`, and `Reader` monads
- Added `pure`, `liftA2` Applicative helper functions
- Added `bind` and `of` methods to Either and Maybe type classes
- Added `mcompose`, `bind`, `IO`, `_print`, `getChar`, `putChar`, `putStr`, `getLine`, `interact`, `readFile`, `writeFile`, `appendFile`, `readIO`, `state`, `gets`, `modify`, `evalState`, `execState`, `put`, `runState`, `fromValue`, `concat`, `prepend`, `append`, `head`, `tail`, `reader`, `runReader`, `either`, `isLeft`, `isRight`, `lefts`, `rights`, `fromLeft`, `partitionEithers`, `maybe`, `isJust`, `isNothing`, `fromJust`, `fromNothing`, `maybeToList`, `listToMaybe`, `catMaybes`, `mapMaybe`, `mapReader`, `withReader`, `ask`, `writer`, `runWriter`, `execWriter`, and `mapWriter` monad functions
- Added `flip` helper function
- Added `letIn` function

## v1.10.0

- Added immutable collections
- Added object matching capability to `patternMatch`
- Modified `patternMatch` array matching to give more concise match results
- Jettisoned reverse function
- Added `mapDeep`, `omit`, `addKeys`, `last`, `reject`, and `mean` helper functions

## v1.9.0

- Refined pattern matching algorithm
- Modified `dropLeft`, `dropRight`, `map`, and `filter` helper functions
- Added `every`, `any`, `where`, `reduceRight`, `curryRight`, `foldRight`, `min`, `max`, `groupBy`, and `patternMatch` helper functions

## v1.8.0

- Added pattern matching to library
- Removed `invalidArrayKey`, `invalidArrayValue`, `emptyArray`, and `memoizationError` callback functions
- Modified `map`, `pick`, `fold`, `pluck`, `reduce`, `filter`, `memoize`, and `isArrayOf` helper functions
- Added `fill`, `partial`, `indexOf`, `reverse`, `toPairs`, `fromPairs`, `match` helper functions

## v1.7.2

- Modified `orElse` methods in Maybe and Either monads
- Added `flatMap` method to State and List monads

## v1.7.1

- Modified throttle function to accept multiple arguments
- Added type signatures and doc blocks
- Added immutable definition of `concat`

## v1.7.0

- Added `ListMonad`

## v1.6.0

- Modified `filter` function
- Changed parameter order of the `reduce` function

## v1.5.0

- Added `map`, `filter`, `fold`, and `reduce` helper functions

## v1.4.0

- Added callback signatures to `pluck`, `pick`, `isArrayOf`, and `memoize` helper functions
- Replaced `extractErrorMessage` callback function
- Added `IO`, `Reader`, `Writer`, and `State` monads
- Added `concat` and `throttle` helper functions
- Added `invalidArrayKey`, `invalidArrayValue`, `emptyArray`, and `memoizationError` callback functions
- Jettisoned `Monad`

## v1.3.0

- Added `filter` and `flatMap` functions to `Monad`

## v1.2.1

- Fixed partialRight behavior in `partialLeft`
- Fixed error with mixed type arrays in `isArray` helper function

## v1.2.0

- Added `isArrayOf`, `partialRight`, and `partialLeft` helper functions
- Added `TransientMutator` trait
- Jettisoned `partial` helper function

## v1.1.0

- Added `head`, `tail`, and `partition` helper functions

## v1.0.0

- First production release
- Added `compose`, `constantFunction`, `curry`, `curryN`, `extend`, `identity`, `memoize`, `partial`, `pick`, `pluck`, `zip`, and `unzip` helper functions
- Added `Either`, `Maybe`, `CollectionApplicative`, and `Monad` typeclasses
