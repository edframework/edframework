<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 20/02/2018
 * Time: 10:51
 */

use Edogawa\Core\Database\Table;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{

    public function setUp()
    {
        $this->table = new Table();
    }

    /**
     * @test
     */
    public function testAll()
    {
        $this->assertNotEmpty($this->table->all());
    }

    /**
     * @test
     */
    public function testCountAll()
    {
        $this->assertEquals(87 , (int) $this->table->countAll());
    }

}
