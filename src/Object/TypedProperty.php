<?php
namespace Teto\Object;
use InvalidArgumentException;
use OutOfRangeException;

/**
 * Typed property function for class
 *
 * @package    Teto
 * @subpackage Object
 * @copyright  2014 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
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
     * @throws OutOfRangeException
     * @throws InvalidArgumentException
     * @link   http://php.net/manual/language.oop5.magic.php
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
        if ($type->len !== null) {
            ValidationHelper::assertCount($type->len, $value);
        }

        $this->properties[$name] = $value;
    }

    /**
     * Get property (magic method)
     *
     * @param  string $name
     * @return mixed
     * @link   http://php.net/manual/language.oop5.magic.php
     */
    public function __get($name)
    {
        if (!isset(self::$property_types[$name])) {
            throw new \OutOfRangeException("Unexpected key:'$name'");
        }

        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * @return boolean
     * @link   http://php.net/manual/language.oop5.magic.php
     */
    public function __isset($name)
    {
        return isset($this->properties[$name]);
    }

    /**
     * @link http://php.net/manual/language.oop5.magic.php
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
