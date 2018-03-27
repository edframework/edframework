<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 19/02/2018
 * Time: 21:38
 */

use Edogawa\Core\Controllers\EdogawaController;

class EdogawaControllerTest extends PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->controller = new EdogawaController();
    }

    /**
     * @test
     */
    public function testModel()
    {
        $this->assertEquals(new \Edogawa\App\Modeles\Test , $this->controller->loadModel('Test'));
    }

    /**
     * @test
     */
    public function testCore()
    {
        $this->assertEquals(new Edogawa\Core\Validator\Validation , $this->controller->loadCore('Validator\Validation'));
    }

    /**
     * @test
     */
    public function testHelper()
    {
        $this->assertEquals(new Edogawa\Helpers\Mail , $this->controller->loadHelper('Mail'));
    }

}