<?php

/**
 * _props
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Fold.php';

/**
 * _props
 * extracts properties from PHP object
 *
 * _props :: a -> Object -> Bool -> Array
 *
 * @internal
 * @param mixed $object
 * @param Reflector $ref
 * @param boolean $recurse
 * @return array
 */
function _props(
  $object,
  \Reflector $ref = null,
  bool $recurse   = false
): array {
  if (!\is_object($object)) {
    return $object;
  }

  if (\is_null($ref)) {
    $ref = new \ReflectionClass($object);
  }

  if (\is_null($ref)) {
    return $object;
  }

  $props = PHP_VERSION_ID < 80100 ?
    $ref->getProperties(
      \ReflectionProperty::IS_STATIC |
      \ReflectionProperty::IS_PUBLIC |
      \ReflectionProperty::IS_PRIVATE |
      \ReflectionProperty::IS_PROTECTED
    ) :
    $ref->getProperties(
      \ReflectionProperty::IS_STATIC |
      \ReflectionProperty::IS_PUBLIC |
      \ReflectionProperty::IS_PRIVATE |
      \ReflectionProperty::IS_READONLY |
      \ReflectionProperty::IS_PROTECTED
    );

  return _fold(
    function (array $acc, $prop, $key) use ($object, $recurse) {
      if ($prop instanceof \ReflectionProperty) {
        $name = $prop->getName();

        if (PHP_VERSION_ID < 80100) {
          $prop->setAccessible(true);
        }

        $value      = $prop->getValue($object);
        if (!$recurse) {
          $acc[$name] = $value;
        }

        if (\is_object($value) && $recurse) {
          $acc[$name][] = _refobj($value);
        }
      } else {
        if (
          \is_object($prop) &&
          !($prop instanceof \ReflectionProperty) &&
          $recurse
        ) {
          $acc = \array_merge($acc, _refobj($prop));
        } else {
          $acc[$key] = $prop;
        }
      }

      return $acc;
    },
    !empty($props) ? $props : \get_object_vars($object),
    []
  );
}
