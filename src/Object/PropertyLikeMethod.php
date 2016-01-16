<?php
namespace Teto\Object;

/**
 * Make Property like method
 *
 * @package    Teto
 * @subpackage Object
 * @copyright  2014 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 */
trait PropertyLikeMethod
{
    /**
     * Call method as property (magic method)
     *
     * @param  string $name
     * @return mixed
     * @link   http://php.net/manual/language.oop5.magic.php
     */
    public function __get($name)
    {
        if (!isset(self::$property_like_methods)) {
            throw new \LogicException(static::class.'::$property_like_methods is not set.');
        }

        if (isset(self::$property_like_methods[$name])) {
            $method = self::$property_like_methods[$name];
        } elseif (in_array($name, self::$property_like_methods)) {
            $method = $name;
        } elseif (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new \OutOfRangeException("Unexpected key:'$name'");
        }

        return call_user_func([$this, $method]);
    }
}
