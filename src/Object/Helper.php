<?php

namespace Teto\Object;

/**
 * Interface for array compatible object
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class Helper
{
    /**
     * Convert object to array recursive
     *
     * @param  mixed $ary_or_obj
     * @return array|null
     */
    public static function toArray($ary_or_obj, $is_toplevel = true)
    {
        if ($ary_or_obj instanceof ToArrayInterface) {
            return $ary_or_obj->toArray();
        }

        if (!is_array($ary_or_obj) && !($ary_or_obj instanceof \Traversable)) {
            return $is_toplevel ? null : $ary_or_obj;
        }

        $array = [];
        foreach ($ary_or_obj as $i => $elm) {
            $array[$i] = Helper::toArray($elm, false);
        }

        return $array;
    }
}
