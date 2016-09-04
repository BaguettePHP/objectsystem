<?php

namespace Teto\Object;

/**
 * Private property behaves like read only.
 *
 * NOTICE: You may not be able to imagine the behavior of this trait in the inherited class.
 *
 * @see \Teto\Object\PrivateGetterTest
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
trait PrivateGetter
{
    public function __get($name)
    {
        return $this->$name;
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }
}
