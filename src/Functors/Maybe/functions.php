<?php

/**
 * Maybe type helper functions.
 *
 * @see hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Maybe;

use Chemem\Bingo\Functional\Functors\Maybe\Maybe as Mtype;

use function Chemem\Bingo\Functional\Algorithms\compose;
use function Chemem\Bingo\Functional\Algorithms\fold;
use function Chemem\Bingo\Functional\Algorithms\head;
use function Chemem\Bingo\Functional\Algorithms\identity as id;
use function Chemem\Bingo\Functional\Algorithms\partialLeft;

/**
 * maybe function
 * Applies function to value inside just if Maybe value is not Nothing; default value otherwise.
 *
 * maybe :: b -> (a -> b) -> Maybe a -> b
 *
 * @param mixed        $default
 * @param callable     $function
 * @param object Maybe $maybe
 *
 * @return mixed
 */

const maybe = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\maybe';

function maybe($default, callable $function, Mtype $maybe)
{
    return $maybe instanceof Nothing ? $default : $maybe->flatMap($function);
}

/**
 * isJust function
 * returns True if its argument is of the form Just.
 *
 * isJust :: Maybe a -> Bool
 *
 * @param object Maybe
 *
 * @return bool
 */
const isJust = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\isJust';

function isJust(Mtype $maybe)
{
    return $maybe->isJust();
}

/**
 * isNothing function
 * returns True if its argument is of the form Nothing.
 *
 * isNothing :: Maybe a -> Bool
 *
 * @param object Maybe
 *
 * @return bool
 */
const isNothing = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\isNothing';

function isNothing(Mtype $maybe)
{
    return $maybe->isNothing();
}

/**
 * fromJust function
 * extracts the element out of a Just and throws an error if its argument is Nothing.
 *
 * fromJust :: Maybe a -> a
 *
 * @param object Maybe $maybe
 *
 * @return mixed
 */
const fromJust = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\fromJust';

function fromJust(Mtype $maybe)
{
    if ($maybe instanceof Nothing) {
        throw new \Exception('Maybe.fromJust: Nothing');
    }

    return $maybe->getJust();
}

/**
 * fromMaybe function
 * returns default value if maybe is Nothing; returns Just value otherwise.
 *
 * fromMaybe :: a -> Maybe a -> a
 *
 * @param mixed        $default
 * @param object Maybe $maybe
 *
 * @return mixed
 */
const fromMaybe = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\fromMaybe';

function fromMaybe($default, Mtype $maybe)
{
    return $maybe instanceof Nothing ? $default : $maybe->getJust();
}

/**
 * listToMaybe function
 * returns Nothing on an empty list or Just a where a is the first element of the list.
 *
 * listToMaybe :: [a] -> Maybe a
 *
 * @param array $list
 *
 * @return object Maybe
 */
const listToMaybe = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\listToMaybe';

function listToMaybe(array $list): Mtype
{
    return empty($list) ? Mtype::nothing() : Mtype::fromValue(head($list));
}

/**
 * maybeToList function
 * returns an empty list when given Nothing or a singleton list when not given Nothing.
 *
 * maybeToList :: Maybe a -> [a]
 *
 * @param object Maybe $maybe
 *
 * @return array
 */
const maybeToList = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\maybeToList';

function maybeToList(Mtype $maybe): array
{
    return $maybe instanceof Nothing ? id([]) : [$maybe->getJust()];
}

/**
 * catMaybes function
 * takes a list of Maybes and returns a list of all the Just values.
 *
 * catMaybes :: [Maybe a] -> [a]
 *
 * @param array $maybes
 *
 * @return array
 */
const catMaybes = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\catMaybes';

function catMaybes(array $maybes): array
{
    return fold(
        function ($list, Mtype $maybe) {
            if ($maybe instanceof Just) {
                $list[] = $maybe->getJust();
            }

            return $list;
        },
        $maybes,
        id([])
    );
}

/**
 * mapMaybe function
 * The mapMaybe function is a version of map which can throw out elements.
 *
 * mapMaybe :: (a -> Maybe b) -> [a] -> [b]
 *
 * @param callable $function
 * @param array    $values
 *
 * @return array
 */
const mapMaybe = 'Chemem\\Bingo\\Functional\\Functors\\Maybe\\mapMaybe';

function mapMaybe(callable $function, array $values): array
{
    $map = compose(partialLeft('array_map', $function), catMaybes);

    return $map($values);
}
