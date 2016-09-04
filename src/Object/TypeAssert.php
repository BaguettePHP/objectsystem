<?php

namespace Teto\Object;

/**
 * Argument type assertion methods
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
trait TypeAssert
{
    /**
     * Assert a value is expected typed
     *
     * @param string $expected_type
     * @param string $name  Variable name (for error message)
     * @param mixed  $value Received value
     * @param bool   $is_nullable
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    protected static function assertValue($expected_type, $name, $value, $is_nullable)
    {
        if ($is_nullable && $value === null) {
            return; // through
        } elseif ($expected_type === 'mixed') {
            return; // through
        } elseif ($expected_type === 'enum') {
            if (!isset(self::$enum_values) || !isset(self::$enum_values[$name])) {
                new \LogicException("Doesn't set self::\$enum_values[$name]");
            }

            if (in_array($value, self::$enum_values[$name], true)) {
                return;
            }

            $expects = '['. implode(', ', self::$enum_values[$name]) . ']';
            throw new \InvalidArgumentException(self::message($expects, $value, $name));
        } elseif (
               ($expected_type === 'int'      && is_int($value))
            || ($expected_type === 'string'   && is_string($value))
            || ($expected_type === 'float'    && is_float($value))
            || ($expected_type === 'array'    && is_array($value))
            || ($expected_type === 'bool'     && is_bool($value))
            || ($expected_type === 'object'   && is_object($value))
            || ($expected_type === 'scalar'   && is_scalar($value))
            || ($expected_type === 'callable' && is_callable($value))
            || ($expected_type === 'resource' && is_resource($value))
        ) {
            return;
        } elseif (is_object($value) && $value instanceof $expected_type) {
            return;
        }

        throw new \InvalidArgumentException(self::message($expected_type, $value, $name));
    }

    /**
     * Assert a value is integer
     *
     * @param mixed  $value Received value
     * @param string $name  Variable name (for error message)
     * @throws \InvalidArgumentException
     */
    protected static function assertInt($value, $name = null)
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException(self::message('int', $value, $name));
        }
    }

    /**
     * Assert a value is string
     *
     * @param mixed  $value Received value
     * @param string $name  Variable name (for error message)
     * @throws \InvalidArgumentException
     */
    protected static function assertString($value, $name = null)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException(self::message('string', $value, $name));
        }
    }

    /**
     * Assert a value is array or array like object (that inplements ArrayAccess)
     *
     * @param mixed  $value Received value
     * @param string $name  Variable name (for error message)
     * @throws \InvalidArgumentException
     * @see    http://php.net/manual/class.arrayaccess.php
     */
    protected static function assertArrayOrObject($value, $name = null)
    {
        if (!is_array($value) && !$value instanceof \ArrayAccess) {
            throw new \InvalidArgumentException(self::message('array or ArrayAccess', $value, $name));
        }
    }

    /**
     * Assert a value is instance of $class
     *
     * @param mixed  $value Received value
     * @param string $class Class name
     * @param string $name  Variable name (for error message)
     * @throws \InvalidArgumentException
     */
    protected static function assertInstanceOf($value, $class, $name = null)
    {
        if (!$value instanceof $class) {
            throw new \InvalidArgumentException(self::message($class, $value, $name));
        }
    }

    /**
     * @param  string      $expected_type
     * @param  mixed       $value
     * @param  string|null $name
     * @return string
     */
    private static function message($expected_type, $value, $name)
    {
        $type = is_object($value) ? get_class($value) : gettype($value);
        $vars = ($name === null) ? $type : "$name as $type";

        return "got \$$vars (expects $expected_type)";
    }
}
