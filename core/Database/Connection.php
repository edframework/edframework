<?php
/**
 * Created by PhpStorm.
 * User: Cedric Edogawa
 * Date: 30/06/2017
 * Time: 20:23
 */

namespace Edogawa\Core\Database;

/**
 * Classe Connection
 *
 * Fournit des méthodes statiques pour la connexion à la base de données
 *
 * @package Edogawa\Core\Database
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Connection
{

    /**
     * @var \PDO
     */
    private static $pdo;

    /**
     * @var string
     */
    private static $db;

    /**
     * Initialise une connexion à la base de donnée
     *
     * @param string $db
     * @return mixed
     */
    private static function getConnection(string $db)
    {
        if (!empty(self::$db) and $db == self::$db){
            if (empty(self::$pdo[$db])) {
                if (DATABASE[$db]['DATABASE'] == 'mysql'){
                    self::$pdo['db'] = new \PDO('mysql:host=' . DATABASE[$db]['HOST'] . ';dbname=' . DATABASE[$db]['DATABASE_NAME'], DATABASE[$db]['LOGIN'], DATABASE[$db]['PASSWORD'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                }elseif (DATABASE[$db]['DATABASE'] == 'oci'){
                    self::$pdo['db'] = new \PDO('oci:host='.DATABASE[$db]['HOST'].'dbname=' . DATABASE[$db]['DATABASE_NAME'], DATABASE[$db]['LOGIN'], DATABASE[$db]['PASSWORD'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                }elseif (DATABASE[$db]['DATABASE'] == 'pgsql'){
                    self::$pdo['db'] = new \PDO('pgsql:host='.DATABASE[$db]['HOST'].';port='.DATABASE[$db]['PORT'].';dbname='.DATABASE[$db]['DATABASE_NAME'].';user='.DATABASE[$db]['LOGIN'].';password='.DATABASE[$db]['PASSWORD']);
                }
            }
        }else{
            if (DATABASE[$db]['DATABASE'] == 'mysql'){
                self::$pdo['db'] = new \PDO('mysql:host=' . DATABASE[$db]['HOST'] . ';dbname=' . DATABASE[$db]['DATABASE_NAME'], DATABASE[$db]['LOGIN'], DATABASE[$db]['PASSWORD'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            }elseif (DATABASE[$db]['DATABASE'] == 'oci'){
                self::$pdo['db'] = new \PDO('oci:host='.DATABASE[$db]['HOST'].'dbname=' . DATABASE[$db]['DATABASE_NAME'], DATABASE[$db]['LOGIN'], DATABASE[$db]['PASSWORD'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            }elseif (DATABASE[$db]['DATABASE'] == 'pgsql'){
                self::$pdo['db'] = new \PDO('pgsql:host='.DATABASE[$db]['HOST'].';port='.DATABASE[$db]['PORT'].';dbname='.DATABASE[$db]['DATABASE_NAME'].';user='.DATABASE[$db]['LOGIN'].';password='.DATABASE[$db]['PASSWORD']);
            }
            self::$db = $db;
        }
        self::$pdo['db']->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return self::$pdo['db'];
    }

    /**
     * Récupère l'instance démarrée
     *
     * @param string $db
     * @return mixed
     */
    public static function getInstance($db = DEFAULT_DATABASE)
    {
        return self::getConnection($db);
    }
}
