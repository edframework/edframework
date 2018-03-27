<?php
namespace Edogawa\Core\Security;

/**
 * Class Debug
 * @package Edogawa\Core\Security
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Debug
{

    /**
     * Variable qui définit si le mode debug est activé pour l'affichage des vues
     * @var bool
     */
    private static $debug = false;

    /**
     * Définit la variable de debug
     */
    public static function setDebug()
    {
        self::$debug = true;
    }

    /**
     * Retourne la variable de debug
     *
     * @return bool
     */
    public static function getDebug()
    {
        return self::$debug;
    }

}

?>
