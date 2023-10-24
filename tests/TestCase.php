<?php

namespace Teto;

use function count;
use function explode;
use function func_get_args;
use function is_array;
use function is_object;
use function is_string;

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
abstract class TestCase extends \Yoast\PHPUnitPolyfills\TestCases\TestCase
{
    /**
     * @param  string|array $class_method "Klass::method_name"
     * @return \Closure
     */
    public static function getPrivateMethodAsPublic($class_method)
    {
        if (is_string($class_method)) {
            list($class, $method) = explode('::', $class_method, 2);
        } elseif (is_array($class_method) && count($class_method) === 2) {
            list($class, $method) = $class_method;
        } else {
            throw new \LogicException();
        }

        $ref = new \ReflectionMethod($class, $method);
        $ref->setAccessible(true);
        $obj = is_object($class) ? $class : null;

        return function () use ($class, $ref, $obj) {
            $args = func_get_args();
            return $ref->invokeArgs($obj, $args);
        };
    }
}
