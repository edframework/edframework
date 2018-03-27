<?php

namespace Edogawa\Core\Session;

/**
 * Class Session
 * @package Edogawa\Core\Session
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Session
{

    /**
     * Démarre une session
     */
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    /**
     * Définit une donnée pour la session
     *
     * @param string $name
     * @param $value
     */
    public static function set(string $name, $value)
    {
        self::start();
        $_SESSION[$name] = $value;
    }

    /**
     * Définit le token contre la faille CSRF
     */
    public static function setToken()
    {
        Session::start();
        if (!Session::get('token')){
            Session::set('token' , str_shuffle(sha1("Ed".session_id()."Token")) , 1);
        }
    }

    /**
     * Supprime une session
     *
     * @param string $name
     * @return bool
     */
    public static function remove($name = "")
    {
        self::start();
        if (empty($name)) {
            unset($_SESSION);
        } else {
            $keys = explode('$' , $name);
            if (count($keys) == 1){
                if (isset($_SESSION[$name])){
                    unset($_SESSION[$name]);
                    return true;
                }else{
                    return false;
                }
            }else{
                $new_name = implode('$',array_shift($keys));
                return self::remove($new_name);
            }
        }
    }

    /**
     * Retourne la valeur défint dans une session
     * Le "$" sépare chaques dimensions du tableau
     *
     * @param string $name
     * @return mixed
     */
    public static function get($name = "")
    {
        self::start();
        if (empty($name)) {
            return $_SESSION;
        } else {
            $keys = explode('$' , $name);
            if (count($keys) == 1){
                if (isset($_SESSION[$name])){
                    return $_SESSION[$name];
                }else{
                    return false;
                }
            }else{
                $new_name = implode('$',array_shift($keys));
                return self::get($new_name);
            }
        }
    }

    /**
     * Détruit la session
     */
    public static function destroy()
    {
        self::start();
        session_destroy();
    }

}

?>
