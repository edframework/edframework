<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 19/02/2018
 * Time: 19:55
 */

use PHPUnit\Framework\TestCase;

use Edogawa\Core\App\Loader;

class loaderTest extends TestCase
{
    /**
     * @test
     */
    public function phpTest()
    {
        $this->assertEquals('Hello world' , Loader::php('test.php'));
    }

    /**
     * @test
     */
    public function jsonTest()
    {
        $this->assertEquals(json_decode('{
          "msg" : "Hello World"
        }') , Loader::json('tests/unit/test.json'));
    }
}