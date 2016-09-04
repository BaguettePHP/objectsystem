<?php

namespace Teto\Object;

/**
 * Interface for array compatible object
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
interface ToArrayInterface
{
    /**
     * @return array
     */
    public function toArray();
}
