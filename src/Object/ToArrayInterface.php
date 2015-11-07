<?php
namespace Teto\Object;

/**
 * Interface for array compatible object
 *
 * @package    Teto
 * @subpackage Object
 * @author     USAMI Kenta <tadsan@zonu.me>
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
interface ToArrayInterface
{
    /**
     * @return array
     */
    public function toArray();
}
