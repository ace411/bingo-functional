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

### Fixed the following problems

- the error message shown when a mixed array (array containing more than one type) is supplied to the isArray() function.

- the partialRight() behavior of partialLeft()
