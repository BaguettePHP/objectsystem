<?php

namespace Teto\Object;

/**
 * Typed property function for class
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
trait TypedProperty
{
    use TypeAssert;

    /** @var array */
    private $properties = [];

    /**
     * Set property (magic method)
     *
     * @param  string $name
     * @param  mixed  $value
     * @throws \OutOfRangeException      If you set to undefined property
     * @throws \InvalidArgumentException If differed from the defined type
     * @throws \RangeException           If differed from the defined length
     * @see    http://php.net/manual/language.oop5.magic.php
     */
    public function __set($name, $value)
    {
        if (!isset(self::$property_types[$name])) {
            throw new \OutOfRangeException("Unexpected key:'$name'");
        }

        $type = TypeDefinition::parse(self::$property_types[$name]);

        if ($type->is_array) {
            self::assertArrayOrObject($value);
            $values = $value;
        } else {
            $values = [$value];
        }

        foreach ($values as $v) {
            self::assertValue($type->expected, $name, $v, $type->is_nullable);
        }
        if ($type->len !== null && count($value) !== $type->len) {
            throw new \RangeException("Unexpected length:{$name} (expects {$type->len})");
        }

        $this->properties[$name] = $value;
    }

    /**
     * Get property (magic method)
     *
     * @param  string $name
     * @return mixed
     * @see    http://php.net/manual/language.oop5.magic.php
     */
    public function __get($name)
    {
        if (!isset(self::$property_types[$name])) {
            throw new \OutOfRangeException("Unexpected key:'$name'");
        }

        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * @param  string $name
     * @return bool
     * @see    http://php.net/manual/language.oop5.magic.php
     */
    public function __isset($name)
    {
        return isset($this->properties[$name]);
    }

    /**
     * @param string $name
     * @see   http://php.net/manual/language.oop5.magic.php
     */
    public function __unset($name)
    {
        if (isset(self::$property_types[$name])) {
            $this->properties[$name] = null;
        }
    }

    /**
     * @param array
     */
    private function setProperties(array $properties)
    {
        foreach (self::$property_types as $name => $_) {
            if (isset($properties[$name])) {
                $this->$name = $properties[$name];
            }
        }
    }
}
