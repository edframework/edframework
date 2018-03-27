<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 19/02/2018
 * Time: 15:37
 */

use PHPUnit\Framework\TestCase;
use Edogawa\Core\App\App;
use Edogawa\Core\Database\QueryBuilder;

class appTest extends TestCase
{
    /**
     * test
     */
    public function getTableTest()
    {
        $this->assertEquals(App::getTable('Besoin') , new Edogawa\App\Table\Besoin);
    }

    /**
     * @test
     */
    public function queryTest()
    {
        $this->assertInstanceOf(QueryBuilder::class , new QueryBuilder());
        $query = "SELECT * FROM table";
        $queryBuilder = App::query()->select('table')->champ('*')->end('db');
        $this->assertEquals($query , $queryBuilder);
    }

}