<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 30/12/2017
 * Time: 00:26
 */

namespace Edogawa\Helpers;

use Edogawa\Core\Session\Session;

/**
 * Class FlashMessage
 * @package Edogawa\Helpers
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class FlashMessage
{

    /**
     * Définit un message flash
     *
     * @param string $type
     * @param string|array $message
     */
    public static function set(string $type , $message)
    {
        $flash = [];
        $flash[$type][] = $message;
        Session::set('flashmessage',$flash);
    }

    /**
     * Récupère tous les messages flash
     *
     * @param string $type
     * @return bool|array
     */
    public static function get(string $type = "")
    {
        if (Session::get('flashmessage')){
            if ($type == ""){
                $data = Session::get('flashmessage');
                Session::remove('flashmessage');
            }else{
                $data = Session::get('flashmessage$'.$type);
                Session::remove('flashmessage$'.$type);
            }
        }else{
            return false;
        }
        return $data;
    }

    /**
     * Ajouter un message de succès ou récupère tous ces messages
     *
     * @param string $message
     * @return array|bool
     */
    public static function success(string $message = "")
    {
        if (!empty($message)){
            self::set('success' , $message);
            return true;
        }else{
            return self::get('success');
        }
    }

    /**
     * Ajouter un message d'erreur ou récupère tous ces messages
     *
     * @param string $message
     * @return array|bool
     */
    public static function error(string $message = "")
    {
        if (!empty($message)){
            self::set('error' , $message);
            return true;
        }else{
            return self::get('error');
        }
    }

    /**
     * Ajouter un message de warning ou récupère tous ces messages
     *
     * @param string $message
     * @return array|bool
     */
    public static function warning(string $message = "")
    {
        if (!empty($message)){
            self::set('warning' , $message);
            return true;
        }else{
            return self::get('warning');
        }
    }

    /**
     * Ajouter un message d'information ou récupère tous ces messages
     *
     * @param string $message
     * @return array|bool
     */
    public static function info(string $message = "")
    {
        if (!empty($message)){
            self::set('info' , $message);
            return true;
        }else{
            return self::get('info');
        }
    }

}