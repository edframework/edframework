<?php

namespace Edogawa\Core\Cookie;

/**
 * Classe Cookie
 *
 * Fournit des méthodes statiques pour gérer les cookies
 *
 * @package Edogawa\Core\Cookie
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Cookie
{

    /**
     * Définit un cookie
     *
     * @param string $name
     * @param string $value
     * @param int $time
     * @return bool
     */
    public static function set(string $name, string $value = "", int $time = 3600)
    {
        $time = time() + $time;
        return setCookie($name, $value, $time);
    }

    /**
     * Supprime le cookie
     *
     * @param string $name
     * @return bool
     */
    public static function remove(string $name)
    {
        return self::set($name, "", -1);
    }

    /**
     * Récupère la valeur du cookie
     *
     * @param string $name
     * @return string
     */
    public static function get(string $name)
    {
        return $_COOKIE[$name];
    }
}
