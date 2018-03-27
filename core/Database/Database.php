<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 15/12/2017
 * Time: 21:14
 */

namespace Edogawa\Core\Database;


use Edogawa\Core\App\App;
use Edogawa\Helpers\Encode;

/**
 * Classe Database
 *
 * Fournit des méthodes statiques pour créer, afficher les propriétés de la base de données, des tables de la Base de données
 *
 * @package Edogawa\Core\Database
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Database
{

    /**
     * Retourne la liste des bases de données disponibles
     *
     * @return array
     */
    public static function show()
    {
        App::query()->query("SHOW DATABASES");
        App::query()->execQuery();
        return App::query()->resultQuery("array");
    }

    /**
     * Crée une base de données
     *
     * @param string $name
     * @return void
     */
    public static function create(string $name)
    {
        App::query()->query("CREATE DATABASE " . $name);
    }

    /**
     * Récupère les tables disponibles dans la base de données
     *
     * @param string $database
     * @return array|json|string
     */
    public static function tables(string $database)
    {
        try
        {
            App::query()->query("show table status from `{$database}`");
            App::query()->execQuery();
            return App::query()->resultQuery();
        }catch (\Exception $e){
            if ($e->getCode() == 42000){
                return -3;
            }
            return Encode::json($e);
        }
    }

    /**
     * Récupère les attributs de la table
     *
     * @param $database
     * @param $table
     * @return array|string
     */
    public static function showTableProperties($database, $table)
    {
        try
        {
            App::query()->query("SHOW FULL COLUMNS FROM {$database}.{$table}");
            App::query()->execQuery();
            return App::query()->resultQuery('array');
        }catch (\Exception $e){
            if ($e->getCode() == "42000"){
                return -3;
            }else if ($e->getCode() == "42S02"){
                return -4;
            }
            return Encode::json($e);
        }
    }
}