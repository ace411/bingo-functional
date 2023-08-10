<?php

/**
 * _refobj function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Fold.php';
require_once __DIR__ . '/_Props.php';

const _refobj = __NAMESPACE__ . '\\_refobj';

/**
 * _refobj
 * condense Reflection object into an array structure
 *
 * _refobj :: Object -> Bool -> Array
 *
 * @internal
 * @param object $obj
 * @param boolean $recurse
 * @return array
 */
function _refobj($obj, bool $recurse = false): array
{
  $data = [];

  if ($obj instanceof \Closure || \is_callable($obj)) {
    $ref            = new \ReflectionFunction($obj);
    $data['name']   = $ref->getName();
    $data['params'] = _fold(
      function (array $acc, \ReflectionParameter $param) {
        if (!\is_null($param) && !\is_null($param->getType())) {
          $acc[$param->getName()] = $param->getType()->getName();
        }

        return $acc;
      },
      $ref->getParameters(),
      []
    );

    if (!\is_null($ref->getReturnType())) {
      $data['return'] = $ref->getReturnType()->getName();
    }

    $data['file']   = $ref->getFileName();
    $data['static'] = $ref->getStaticVariables();
    $data['ext']    = $ref->getExtensionName();
    $data['scope']  = \is_null($ref->getClosureScopeClass()) ?
      null :
      $ref
        ->getClosureScopeClass()
        ->getName();

    if ($obj instanceof \Closure) {
      $data['start']  = $ref->getStartLine();
      $data['end']    = $ref->getEndLine();
    }
  } else {
    $ref                = new \ReflectionClass($obj);
    $data['name']       = $ref->getName();
    $data['ext']        = $ref->getExtensionName();
    $data['file']       = $ref->getFileName();
    $data['props']      = _props($obj, $ref, $recurse);
    $data['constants']  = $ref->getConstants();
    $data['interfaces'] = $ref->getInterfaceNames();
    $data['traits']     = $ref->getTraitNames();
    $data['methods']    = _fold(
      function (array $acc, \ReflectionMethod $method) {
        $acc[] = $method->getName();

        return $acc;
      },
      $ref->getMethods(),
      []
    );

    if (PHP_VERSION_ID >= 80000) {
      $data['attributes'] = _fold(
        function ($acc, $attr) {
          $acc[] = $attr->getName();

          return $acc;
        },
        $ref->getAttributes(),
        []
      );
    }
  }

  return $data;
}
