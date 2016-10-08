<?php

namespace Teto\Object;

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class HelperTest extends \Teto\TestCase
{
    /**
     * @dataProvider dataProviderFor_toArray
     */
    public function test_toArray($expected, $input)
    {
        $this->assertEquals($expected, Helper::toArray($input));
    }

    public function dataProviderFor_toArray()
    {
        return [
            [null, null],
            [null, 'ab'],
            [null, 1234],
            [[], []],
            [[], new \ArrayObject([])],
            [[], new ObjectArrayTestModel([])],
            [[1, 2, 3], [1, 2, 3]],
            [[1, 2, 3], new \ArrayObject([1, 2, 3])],
            [[1, 2, 3], new ObjectArrayTestModel([1, 2, 3])],
            [[[1], [2, 3], [4 => [5]]], [[1], [2, 3], [4 => [5]]]],
            [[[1], [2, 3], [4 => [5]]], new \ArrayObject([[1], [2, 3], [4 => [5]]])],
            [[[1], [2, 3], [4 => [5]]], new ObjectArrayTestModel([[1], [2, 3], [4 => [5]]])],
            [[[1], [2, 3], [4 => [5]]], new \ArrayObject([[1], new \ArrayObject([2, 3]), [4 => new \ArrayObject([5])]])],
            [[[1], [2, 3], [4 => [5]]], new \ArrayObject([[1], new ObjectArrayTestModel([2, 3]), [4 => new ObjectArrayTestModel([5])]])],
            [[[1], new ObjectArrayTestModel([2, 3]), [4 => new ObjectArrayTestModel([5])]],
             new ObjectArrayTestModel([[1], new ObjectArrayTestModel([2, 3]), [4 => new ObjectArrayTestModel([5])]])],
            [['foo' => 'bar', 'fizz' => 'buzz'], ['foo' => 'bar', 'fizz' => 'buzz']],
        ];
    }
}
