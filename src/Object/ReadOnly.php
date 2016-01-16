<?php
namespace Teto\Object;

/**
 * Restrict write to not accessable property.
 *
 * @see \Teto\Object\PrivateGetterTest
 *
 * @package    Teto
 * @subpackage Object
 * @author     USAMI Kenta <tadsan@zonu.me>
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
trait ReadOnly
{
    public function __set($name, $_value)
    {
        $message = sprintf('%s->%s is not writable property.', static::class, $name);
        throw new \OutOfRangeException($message);
    }
}
