<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 20/02/2018
 * Time: 16:37
 */

use Edogawa\Core\Validator\ValidateURL;
use PHPUnit\Framework\TestCase;

class ValidateURLTest extends TestCase
{

    /**
     * @test
     * @dataProvider urlProvider
     */
    public function testValidate($url)
    {
        $this->assertEquals(1,ValidateURL::validate($url));
    }

    public function urlProvider()
    {
        return [
            ['/Gen/GenAjax.css'],
            ['/Gen/image.js'],
            ['/Generator/GTable/gen.map']
        ];
    }
}
