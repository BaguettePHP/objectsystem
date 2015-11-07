<?php
namespace Teto\Object;

/**
 * @package    Teto
 * @subpackage Object
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 */
class ObjectArrayTestModel implements ToArrayInterface
{
    private $array = [];

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function toArray()
    {
        return $this->array;
    }
}

/**
 * @package    Teto
 * @subpackage Object
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 */
class ObjectArrayTest extends \Teto\TestCase
{
    /**
     * @dataProvider objectArrayProvider
     */
    public function test($objects, $expected)
    {
        $actual = $objects->toArray();

        $this->assertEquals($expected, $actual);

        unset($objects[0]);
        unset($expected[0]);
        $actual = $objects->toArray();

        $this->assertEquals($expected, $actual);
    }

    public function objectArrayProvider()
    {
        return [
            [
                'objects' => new ObjectArray(
                    new ObjectArrayTestModel([1, 2, 3]),
                    new ObjectArrayTestModel([4, 5, 6]),
                    new ObjectArrayTestModel([7, 8, 9])
                ),
                'expected' => [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9],
                ],
            ]
        ];
    }
}
