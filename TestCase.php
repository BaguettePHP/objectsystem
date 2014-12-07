<?php
namespace Tsukudol\Nizicon;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param  string|array $class_method_str "Klass::method_name"
     * @return callable
     */
    public static function getPrivateMethodAsPublic($class_method)
    {
        if (is_string($class_method)) {
            list($class, $method) = explode('::', $class_method, 2);
        } elseif (is_array($class_method)) {
            list($class, $method) = $class_method;
        } else {
            throw new \LogicException;
        }

        $ref = new \ReflectionMethod($class, $method);
        $ref->setAccessible(true);
        $obj = (gettype($class) === 'object') ? $class : null;

        return function () use ($class, $ref, $obj) {
            $args = func_get_args();
            return $ref->invokeArgs($obj, $args);
        };
    }
}
