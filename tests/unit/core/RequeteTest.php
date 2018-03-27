<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 20/02/2018
 * Time: 12:43
 */

use Edogawa\Core\Requete\Requete;
use PHPUnit\Framework\TestCase;

class RequeteTest extends TestCase
{

    /**
     * @test
     */
    public function testPost()
    {
        $this->assertEquals($_POST['postvar'], Requete::post('postvar'));
        Requete::post('postvar' , 'valeur2');
        $this->assertEquals('valeur2', Requete::post('postvar'));
        $_POST['postvar'] = array('p' => array('c' => "val"));
        $this->assertEquals($_POST['postvar']['p']['c'], Requete::post('postvar$p$c'));
    }

    /**
     * @test
     */
    public function testUnsetPost()
    {
        $this->assertTrue(Requete::unsetPost('postvar$p$'));
    }

    /**
     * @test
     */
    public function testGet()
    {
        $this->assertEquals($_GET['getvar'], Requete::get('getvar'));
        Requete::get('getvar' , 'valeur2');
        $this->assertEquals('valeur2', Requete::get('getvar'));
        $_GET['getvar'] = array('p' => array('c' => "val"));
        $this->assertEquals($_GET['getvar']['p'], Requete::get('getvar$p'));
    }

    /**
     * @test
     */
    public function testUnsetGet()
    {
        $this->assertTrue(Requete::unsetGet('getvar'));
    }

    /**
     * @test
     */
    public function testRequest()
    {
        $this->assertEquals($_REQUEST['getvar'], Requete::request('getvar'));
        Requete::request('getvar' , 'valeur2');
        $this->assertEquals('valeur2', Requete::request('getvar'));
        $_REQUEST['getvar'] = array('p' => array('c' => "val"));
        $this->assertEquals($_REQUEST['getvar']['p'], Requete::request('getvar$p'));
    }

}
