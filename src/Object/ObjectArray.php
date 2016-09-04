<?php

namespace Teto\Object;

/**
 * Interface for array compatible object
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class ObjectArray implements \ArrayAccess, \Countable, \IteratorAggregate, ToArrayInterface
{
    private $objects = [];

    /**
     * @param object
     */
    public function __construct()
    {
        $this->objects = func_get_args() ?: [];
    }

    /**
     * @param  ObjectArray|object[] $objects
     * @return ObjectArray
     * @throws InvalidArgumentException
     */
    public static function fromArray($objects)
    {
        if ($objects instanceof ObjectArray) {
            return $objects;
        } elseif (!is_array($objects) && !$objects instanceof ToArrayInterface) {
            throw new \InvalidArgumentException;
        }

        $model_array = new ObjectArray;
        $model_array->objects = array_values($objects);

        return $model_array;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $arrays = [];
        foreach ($this->objects as $k => $object) {
            $arrays[$k] = self::toArrayRec($object);
        }

        return $arrays;
    }

    /**
     * Convert elements to recursive array
     *
     * @param mixed $object
     * @param int   $rec    ネストの深さ
     */
    public static function toArrayRec($object, $rec = 5)
    {
        if ($rec < 1
            || empty($object)
            || is_scalar($object)
        ) {
            return $object;
        }

        if ($object instanceof ToArrayInterface) {
            return $object->toArray();
        } elseif (!is_array($object)) {
            return $object;
        }

        $retval = [];
        foreach ($object as $idx => $obj) {
            $retval[$idx] = self::toArrayRec($obj, $rec - 1);
        }

        return $retval;
    }

    public function getObjects()
    {
        require $this->objects;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->objects);
    }

    /**
     * @param  mixed offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return !empty($this->objects[$offset]);
    }

    /**
     * @param  mixed offset
     * @return mixed
     * @throws OutOfBoundsException
     */
    public function offsetGet($offset)
    {
        if (!array_key_exists($offset, $this->objects)) {
            throw new \OutOfBoundsException("Undefined offset: {$offset}");
        }

        return $this->objects[$offset];
    }

    /**
     * @param  mixed offset
     * @param  mixed value
     * @return void
     * @throws OutOfBoundsException
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->objects[] = $value;
        } else {
            $this->objects[$offset] = $value;
        }
    }

    /**
     * @param  mixed offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->objects[$offset]);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->objects);
    }
}
