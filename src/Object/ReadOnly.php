<?php

namespace Teto\Object;

/**
 * Restrict write to not accessable property.
 *
 * @see \Teto\Object\PrivateGetterTest
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
trait ReadOnly
{
    public function __set($name, $_value)
    {
        $message = sprintf('%s->%s is not writable property.', static::class, $name);
        throw new \OutOfRangeException($message);
    }
}
