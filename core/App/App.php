<?php

namespace Edogawa\Core\App;

use Edogawa\Core\Database\QueryBuilder;

/**
 * Classe App
 *
 * Fournit des méthodes statiques pour atteindre rapidement certaines fonctionnalités
 *
 * @package Edogawa\Core\App
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class App
{

    private static $query;

    /**
     * Retrouve une instance de la table passée dans le paramètre
     *
     * @param string $tableName
     * @return \Edogawa\App\Table\::class;
     */
    public static function getTable($tableName)
    {
        $table = 'Edogawa\App\Table\\' . ucfirst($tableName);
        return new $table();
    }

    /**
     * Renvoie une instance du QueryBuilder
     *
     * @return QueryBuilder
     */
    public static function query()
    {
        if (empty(self::$query)) {
            self::$query = new QueryBuilder();
        }
        return self::$query;
    }

    /**
     * Retourne le fichier de langue sous format json en fonction de la langue
     *
     * @return string
     */
    public static function getJson()
    {
        return Language::getJson();
    }

    /**
     * Retourne le contenu du fichier json envoyé
     *
     * @param string $filename
     * @return Json mixed
     */
    public static function getJsonLoader($filename)
    {
        return Loader::json($filename);
    }
}

?>
