<?php
namespace Teto\Object;

/**
 * Type Definition syntax
 *
 * @package    Teto
 * @subpackage Object
 * @copyright  2014 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 *
 * @property-read string   $expected
 * @property-read boolean  $is_nullable
 * @property-read boolean  $is_array
 * @property-read int|null $len
 */
final class TypeDefinition
{
    /** @var string */
    private $expected;

    /** @var boolean */
    private $is_nullable;

    /** @var boolean */
    private $is_array;

    /** @var int|null */
    private $len;

    public function __construct() {}

    /**
     * @param  string $def Type definition
     * @return TypeDefinition
     */
    public static function parse($def)
    {
        $type = new TypeDefinition;

        preg_match(self::RE_PROPERTY, $def, $matches);

        if (empty($matches[2])) {
            throw new \LogicException();
        }
        $type->is_nullable = !empty($matches[1]);
        $type->expected    = $matches[2];
        $type->is_array    = !empty($matches[3]);
        if (isset($matches[4]) && is_numeric($matches[4])) {
            $type->len = (int)$matches[4];
        }

        return $type;
    }
    const RE_PROPERTY = '/^(\??)([^\s\[\]?]+)((?:\[(\d*)\])?)$/';

    /**
     * @throws \OutOfRangeException
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        throw new \OutOfRangeException;
    }
}
