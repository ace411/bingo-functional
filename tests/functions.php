<?php

/**
 * test functions for assertions
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Tests;

use Chemem\Bingo\Functional\Algorithms as f;
use Chemem\Bingo\Functional\Functors\Lens as l;
use Chemem\Bingo\Functional\Functors\Monads as m;
use Chemem\Bingo\Functional\PatternMatching as p;

/**
 * getClassShortName
 * outputs the short name of a class - sans-namespace
 *
 * getClassShortName :: Object -> String
 *
 * @param object $obj
 * @return string
 */
function getClassShortName($obj): string
{
  $ref = function ($item) {
    return new \ReflectionClass($item);
  };

  $name   = $ref($obj)->getName();
  $parent = $ref($name)->getParentClass();

  return $parent == false ?
    $ref($obj)->getShortName() :
    $ref(f\head($parent))->getShortName();
}

const getClassShortName = __NAMESPACE__ . '\\getClassShortName';

/**
 * assertEquals
 * performs equality check on two functors
 *
 * assertEquals :: Object -> Object -> a -> Bool
 *
 * @param object $fst
 * @param object $snd
 * @param string $property
 * @param mixed $env
 * @return boolean
 */
function assertEquals(object $fst, object $snd, $env = null): bool
{
  return p\patternMatch([
    '["Maybe", "Maybe"]'          => function () use ($fst, $snd) {
      return $fst->getJust() == $snd->getJust();
    },
    '["Either", "Either"]'        => function () use ($fst, $snd) {
      return $fst->isLeft() == $snd->isLeft() || $fst->isRight() == $fst->isRight();
    },
    '["ListMonad", "ListMonad"]'  => function () use ($fst, $snd) {
      return $fst->extract() == $snd->extract();
    },
    '["IO", "IO"]'                => function () use ($fst, $snd) {
      return $fst->exec() == $snd->exec();
    },
    '["Reader", "Reader"]'        => function () use ($fst, $snd, $env) {
      return $fst->run($env) == $snd->run($env);
    },
    '["State", "State"]'          => function () use ($fst, $snd, $env) {
      return $fst->run($env) == $snd->run($env);
    },
    '["Writer", "Writer"]'        => function () use ($fst, $snd) {
      return $fst->run() == $snd->run();
    },
    '["Applicative", "Applicative"]' => function () use ($fst, $snd) {
      return $fst->getValue() == $snd->getValue();
    },
    '["Collection", "Collection"]' => function () use ($fst, $snd) {
      return $fst->toArray() == $snd->toArray();
    },
    '_'                           => function () {
      return false;
    },
  ], f\map(getClassShortName, [$fst, $snd]));
}

const assertEquals = __NAMESPACE__ . '\\assertEquals';

/**
 * lensLaws
 * performs necessary proof checks for Lenses
 *
 * lensLaws :: (s -> a) -> ((a, s) -> s) -> [a] -> b -> Array
 *
 * @param callable $get
 * @param callable $set
 * @param array|object $store
 * @param mixed $val
 * @return array
 */
function lensLaws(
    callable $get,
    callable $set,
    $store,
    $val = null
): array {
  $lens = l\lens($get, $set);

  return [
    // view l (set l x) = x
    'first'   => l\view($lens, l\set($lens, $val, $store)) == $val,
    // set s y . set s x = set s y
    'second'  => l\set($lens, $val, l\set($lens, null, $store)) == l\set($lens, $val, $store),
    // set l (view l z) z = z
    'third'   => l\set($lens, l\view($lens, $store), $store) == $store,
  ];
}

const lensLaws = __NAMESPACE__ . '\\lensLaws';

/**
 * lensFunctorLaws
 * performs Functor law proof checks on lenses
 *
 * lensFunctorLaws :: (s -> a) -> ((a, s) -> s) -> [a] -> (a -> b) -> (a -> c) -> Array
 *
 * @param callable $get
 * @param callable $set
 * @param array|object $store
 * @param callable $fnx
 * @param callable $fny
 * @return array
 */
function lensFunctorLaws(
    callable $get,
    callable $set,
    $store,
    callable $fnx,
    callable $fny
): array {
  $lens = l\lens($get, $set);

  return [
    'identity'    => l\over($lens, f\identity, $store) == $store,
    'composition' =>
      l\over($lens, f\compose($fnx, $fny), $store) ==
        l\over($lens, $fny, l\over($lens, $fnx, $store)),
  ];
}

const lensFunctorLaws = __NAMESPACE__ . '\\lensFunctorLaws';

/**
 * functorLaws
 * performs Functor law proof checks on functors
 *
 * functorLaws :: f a -> (a -> f b) -> (a -> f c) -> Array
 *
 * @param object $functor
 * @param callable $fnx
 * @param callable $fny
 * @return array
 */
function functorLaws(
  object $functor,
  callable $fnx,
  callable $fny,
  $aux = null
): array {
  return [
    // F(id) = id
    'identity'    => assertEquals($functor, $functor->map(f\identity), $aux),
    // F(g o f) = F(g) o F(f)
    'composition' => assertEquals(
      $functor->map(f\compose($fnx, $fny)),
      $functor->map($fnx)->map($fny),
      $aux
    ),
  ];
}

const functorLaws = __NAMESPACE__ . '\\functorLaws';

/**
 * monadLaws
 * performs Monad law proof checks on monads
 *
 * monadLaws :: m a -> (a -> m b) -> (a -> m c) -> a -> d -> Array
 *
 * @param Monadic $monad
 * @param callable $fnx
 * @param callable $fny
 * @param callable $return
 * @param mixed $val
 * @param mixed $aux
 * @return array
 */
function monadLaws(
    object $monad,
    callable $fnx,
    callable $fny,
    callable $return,
    $val,
    $aux = null
): array {
  return [
    // x >>= f = f o x
    'left-identity'   => assertEquals($monad->bind($fnx), $fnx($val), $aux),
    // m >>= return = m
    'right-identity'  => assertEquals(m\bind($return, $monad), $monad, $aux),
    // (m >>= f) >>= g = m >>= (x -> f o x >>= g)
    'associativity'   => assertEquals(
        $monad->bind($fnx)->bind($fny),
        $monad->bind(function ($res) use ($fnx, $fny) {
          return $fnx($res)->bind($fny);
        }),
        $aux
    ),
  ];
}

const monadLaws = __NAMESPACE__ . '\\monadLaws';

/**
 * applicativeLaws
 * performs Applicative law proof checks on Applicatives
 *
 * applicativeLaws :: f a -> (a -> b) -> Array
 *
 * @param object $app
 * @param callable $func
 * @param mixed $val
 * @return array
 */
function applicativeLaws(object $app, callable $func, $val): array
{
  // place value in applicative
  $purex = $app->pure($val);

  // place function in applicative context
  $puref = $app->pure($func);

  return [
    // pure id <*> v = v
    'identity' => $app->pure(f\identity)->ap($purex)->getValue() == $val,
    // u <*> pure v = pure ($ v) <*> u
    'interchange' => assertEquals(
        $app->ap($purex),
        $app
        ->pure(function ($func) use ($val) {
          return $func($val);
        })
        ->ap($app)
    ),
    // pure f <*> pure x = pure (f x)
    'homomorphism' => assertEquals(
        $app->pure($func)->ap($purex),
        $app->pure($func($val))
    ),
    // pure (.) <*> u <*> v <*> w = u <*> (v <*> w)
    'composition' => assertEquals(
        $app
        ->pure(f\compose)
        ->ap($app)
        ->ap($puref)
        ->ap($purex),
        $app->ap($puref->ap($purex))
    ),
    // map f x = pure f <*> x
    'map' => assertEquals(
        $puref->ap($purex),
        $purex->map($func)
    ),
  ];
}

const applicativeLaws = __NAMESPACE__ . '\\applicativeLaws';
