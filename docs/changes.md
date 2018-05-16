---
title: changes
subTitle: Change log for the project
---

# bingo-functional change log

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

- Either ```Left/Right```
- Maybe ```Just/Nothing```
- Applicatives ```Applicative/CollectionApplicative```
- Monad ```Monad```

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

- TransientMutatorTrait ```TransientMutatorTrait```

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

- the ```pluck()```, ```pick()```, ```isArrayOf()```, and ```memoize()``` functions have been given callback signatures.

- the ```extractErrorMessage()``` function and all other related callback functions have been replaced.

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

- Modified the ```filter()``` function to accurately filter values whenever a boolean predicate is defined.

- Changed parameter order of the return value for the ```reduce()``` function.

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

- Modified the ```throttle()``` function to accept multiple arguments

- Added type signatures and doc blocks for functions without any

- Added immutable const definition for ```concat()``` function

## v1.7.2

### Made the following change(s)

- Modified the ```orElse()``` methods of the Left, Right, Nothing, and Just functors

- Added the ```flatMap()``` method to the State and List monads

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