<?php
namespace Teto\Object;

/**
 * @package    Teto
 * @subpackage Object
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 */
class PropertyLikeMethodsTestModel
{
    use PropertyLikeMethod;

    private $string;

    private static $property_like_methods = [
        'mb_strlen',
        'len' => 'strlen',
    ];

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function strlen()
    {
        return strlen($this->string);
    }

    public function mb_strlen()
    {
        return mb_strlen($this->string, 'UTF-8');
    }
}

/**
 * @package    Teto
 * @subpackage Object
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 */
class PropertyLikeMethodsTest extends \Teto\TestCase
{
    public function test()
    {
        $val = new PropertyLikeMethodsTestModel('ぬるぽ');

        $this->assertEquals($val->strlen(), $val->len);
        $this->assertEquals($val->strlen(), $val->strlen);
        $this->assertEquals($val->mb_strlen(), $val->mb_strlen);
    }

    public function test_raiseError()
    {
        $val = new PropertyLikeMethodsTestModel('ぬるぽ');
        $this->setExpectedException(\OutOfRangeException::class, "Unexpected key:'unknown'");

        $_ = $val->unknown;
    }
}
