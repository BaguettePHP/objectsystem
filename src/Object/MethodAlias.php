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
trait MethodAlias
{
    /**
     * Call alias method (magic method)
     *
     * @param  string $name
     * @return mixed
     * @link   http://php.net/manual/language.oop5.magic.php
     */
    public function __call($name, array $args)
    {
        if (!isset(self::$method_aliases)) {
            throw new \LogicException(static::class.'::$method_aliases is not set.');
        }

        if (isset(self::$method_aliases[$name])) {
            $method = self::$method_aliases[$name];
        } elseif (in_array($name, self::$method_aliases)) {
            $method = $name;
        } else {
            throw new \BadMethodCallException(static::class."::{$name}() is not exists.");
        }

        return call_user_func([$this, $method]);
    }
}
