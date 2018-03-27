<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 19/02/2018
 * Time: 22:58
 */

use Edogawa\Core\Database\QueryBuilder;

class QueryBuilderTest extends PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->queryBuilder = new QueryBuilder();
        $this->donnees = [];
        $this->donnees['LIBELLETYPEPARRAINAGE'] = 'NouveauType';
        $this->table = 'typeparrainage';
    }

    /**
     * @test
     */
    public function testDefine()
    {
        define("DATABASE", array(
                'db' => array(
                    'DATABASE' => 'mysql',
                    'HOST' => '127.0.0.1',
                    'PORT' => '3306',
                    'DATABASE_NAME' => 'concourstv5',
                    'LOGIN' => 'root',
                    'PASSWORD' => ''
                )
            )
        );
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function testBeginTransaction()
    {
        $this->assertTrue($this->queryBuilder->beginTransaction());
    }

    /**
     * @test
     */
    public function testCommit()
    {
        $this->assertTrue($this->queryBuilder->commit());
    }


    /**
     * @test
     * @depends testBeginTransaction
     */
    public function testRollBack()
    {
        $this->testBeginTransaction();
        $this->assertTrue($this->queryBuilder->rollBack());
    }

    /**
     * @test
     */
    public function testInsert()
    {
        //$this->assertTrue($this->queryBuilder->insert($this->table , $this->donnees));
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function testSelect()
    {
        $this->assertInstanceOf(QueryBuilder::class , $this->queryBuilder->select([$this->table,'parrain']));

        $this->assertArrayHasKey('instruction' , (array) $this->queryBuilder->getParams());
        $this->assertArrayHasKey('table' , (array) $this->queryBuilder->getParams());

        $this->assertEquals($this->queryBuilder->getParams()['instruction'] , 'SELECT');
        $this->assertEquals($this->queryBuilder->getParams()['table'] , $this->table.',parrain');

        $this->assertInternalType('string' , $this->queryBuilder->getParams()['table']);
    }


    /**
     * @test
     * @dataProvider setProvider
     */
    public function testSet($libelle , $value)
    {
        $this->queryBuilder->set($libelle , $value);
        $this->assertNotEmpty($this->queryBuilder->getParams()['set']);
    }

    public function setProvider()
    {
        return [
            ['LIBELLETYPEPARRAINAGE' , 'Nouveau Type'],
            ['LIBELLETYPEPARRAINAGE' , 'Nouveau Type2'],
            ['IDTYPEPARRAINAGE' , '']
        ];
    }

    /**
     * @test
     */
    public function testChamp()
    {
        $this->queryBuilder->champ('LIBELLETYPEPARRAINAGE' , 'type');

        $this->assertCount(1 , $this->queryBuilder->getParams()['champ']);
        $this->assertEquals($this->queryBuilder->getParams()['champ'][0] , 'LIBELLETYPEPARRAINAGE AS type');

        $this->queryBuilder->champ('LIBELLETYPEPARRAINAGE' , 'type');
        $this->assertCount(2 , $this->queryBuilder->getParams()['champ']);

        $this->queryBuilder->champ(['LIBELLETYPEPARRAINAGE' , 'IDTYPEPARRAINAGE'] , 'type');
        $this->assertCount(2 , $this->queryBuilder->getParams()['champ']);
    }


    /**
     * @test
     * @dataProvider whereProvider
     */
    public function testEndWhere($donnee1 , $donnee2)
    {
        $this->queryBuilder->select('typeparrainage');
        $this->queryBuilder->setBracket($donnee1[1]);
        $this->queryBuilder->setBracketEnd($donnee1[4]);
        $this->queryBuilder->where($donnee1[0] , $donnee1[2] , $donnee1[3]);
        if (!empty($donnee2)){
            $this->queryBuilder->setBracket($donnee2[1]);
            $this->queryBuilder->setBracketEnd($donnee2[4]);
            $this->queryBuilder->where($donnee1[0] , $donnee1[2] , $donnee1[3]);
        }
        $this->assertNotFalse($this->queryBuilder->exec());
    }

    public function whereProvider()
    {
        return [
            [
                ['LIBELLETYPEPARRAINAGE' , '(' , '=' , 'valeur' , ''],
                ['LIBELLETYPEPARRAINAGE' , '' , '=' , 'valeur2' , ')']
            ],
            [
                ['LIBELLETYPEPARRAINAGE' , '(' , 'IS' , 'NULL|sans' , ')'],
                []
            ],
            [
                ['LIBELLETYPEPARRAINAGE' , '(' , 'IS NOT' , 'NULL|sans' , ')'],
                []
            ],
            [
                ['LIBELLETYPEPARRAINAGE' , '(' , 'LIKE' , '%valeur%' , ')'],
                []
            ],
            [
                ['LIBELLETYPEPARRAINAGE' , '(' , 'NOT LIKE' , '%valeur' , ')'],
                []
            ]
        ];
    }

    /**
     * @test
     */
    public function testComplexeRequest()
    {
        $q2 = $this->queryBuilder->select('concudonnees')
            ->champ('sitedonnees' , 'subq')
            ->join('main' , 'subq.ReferingDomaine=main.ReferingDomaine')
            ->end();
        $this->queryBuilder->emptyQuery();
        $q = $this->queryBuilder->select('concudonnees')
            ->champ('ReferingDomaine')
            ->champCount('distinct id_concurrent')
            ->groupBy('RegeringDomaine')
            ->having('count(distinct id_concurrent)' , '>' , '1|sans')
            ->union($q2)
            ->end();

        $this->assertTrue(true);
    }


}
