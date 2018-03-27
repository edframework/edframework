<?php
namespace Edogawa\Core\Requete;

/**
 * Class Requete
 * @package Edogawa\Core\Requete
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Requete
{
    /**
     * Donne accès à la méthode $_POST
     * Le "$" sépare chaques dimensions du tableau
     *
     * @param string $key
     * @param string $value
     * @param bool $set
     * @param string|array $postdata
     * @return mixed
     */
    public static function post(string $key = "", string $value = "", bool $set = true , $postdata = "")
    {
        if (empty($key)) {
            return $_POST;
        } else {
            /**
             * Instruction recurisve pour récupérer la valeurs du post
             */
            if (!$set or ($set and empty($value))) {
                $keys = explode('$' , $key);
                if (count($keys) == 1){
                    if (empty($postdata)){
                        if (isset($_POST[$key])){
                            return $_POST[$key];
                        }else{
                            return false;
                        }
                    }else{
                        if (isset($postdata[$key])){
                            return $postdata[$key];
                        }else{
                            return false;
                        }
                    }
                }else{
                    $name = array_shift($keys);
                    $new_name = implode('$',$keys);
                    if (empty($postdata)){
                        return self::post($new_name , "" , false , $_POST[$name]);
                    }else{
                        return self::post($new_name , "" , false , $postdata[$name]);
                    }
                }
            } else {
                $_POST[$key] = $value;
            }
        }
    }

    /**
     * Supprime une valeur du POST
     *
     * @param string $key
     * @param string|array $postkey
     * @return bool
     */
    public static function unsetPost(string $key = "" , &$postkey = "")
    {
        if (empty($key)) {
            $_POST = [];
            return true;
        } else {
            $keys = explode('$' , $key);
            if (count($keys) == 1){
                if (empty($postkey)){
                    if (isset($_POST[$key])){
                        unset($_POST[$key]);
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    if (isset($postkey[$key])){
                        unset($postkey[$key]);
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                $name = array_shift($keys);
                $new_name = implode('$',$keys);
                if (empty($postkey)){
                    return self::unsetPost($new_name , $_POST[$name]);
                }else{
                    return self::unsetPost($new_name , $postkey[$name]);
                }
            }
        }
    }

    /**
     * Supprime une valeur du GET
     *
     * @param string $key
     * @param string|array $getkey
     * @return bool
     */
    public static function unsetGet(string $key , &$getkey = "")
    {
        if (empty($key)) {
            $_GET = [];
            return true;
        } else {
            $keys = explode('$' , $key);
            if (count($keys) == 1){
                if (empty($getkey)){
                    if (isset($_GET[$key])){
                        unset($_GET[$key]);
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    if (isset($getkey[$key])){
                        unset($getkey[$key]);
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                $name = array_shift($keys);
                $new_name = implode('$',$keys);
                if (empty($getkey)){
                    return self::unsetPost($new_name , $_GET[$name]);
                }else{
                    return self::unsetPost($new_name , $getkey[$name]);
                }
            }
        }
    }

    /**
     * Donne accès à la méthode $_GET
     *Le "$" sépare chaques dimensions du tableau
     *
     * @param string $key
     * @param string $value
     * @param bool $set
     * @param string $getdata
     * @return mixed
     */
    public static function get(string $key = "", string $value = "", bool $set = true , $getdata = "")
    {
        if (empty($key)) {
            return $_GET;
        } else {
            /**
             * Instruction recurisve pour récupérer la valeurs du post
             */
            if (!$set or ($set and empty($value))) {
                $keys = explode('$' , $key);
                if (count($keys) == 1){
                    if (empty($getdata)){
                        if (isset($_GET[$key])){
                            return $_GET[$key];
                        }else{
                            return false;
                        }
                    }else{
                        if (isset($getdata[$key])){
                            return $getdata[$key];
                        }else{
                            return false;
                        }
                    }
                }else{
                    $name = array_shift($keys);
                    $new_name = implode('$',$keys);
                    if (empty($getdata)){
                        return self::get($new_name , "" , false , $_GET[$name]);
                    }else{
                        return self::get($new_name , "" , false , $getdata[$name]);
                    }
                }
            } else {
                $_GET[$key] = $value;
            }
        }
    }

    /**
     * Donne accès à la méthode $_REQUEST
     *Le "$" sépare chaques dimensions du tableau
     *
     * @param string $key
     * @param string $value
     * @param bool $set
     * @param string|array $requestdata
     * @return mixed
     */
    public static function request(string $key = "", string $value = "", bool $set = true , $requestdata = "")
    {
        if (empty($key)) {
            return $_REQUEST;
        } else {
            /**
             * Instruction recurisve pour récupérer la valeurs du request
             */
            if (!$set or ($set and empty($value))) {
                $keys = explode('$' , $key);
                if (count($keys) == 1){
                    if (empty($requestdata)){
                        if (isset($_REQUEST[$key])){
                            return $_REQUEST[$key];
                        }else{
                            return false;
                        }
                    }else{
                        if (isset($requestdata[$key])){
                            return $requestdata[$key];
                        }else{
                            return false;
                        }
                    }
                }else{
                    $name = array_shift($keys);
                    $new_name = implode('$',$keys);
                    if (empty($requestdata)){
                        return self::request($new_name , "" , false , $_REQUEST[$name]);
                    }else{
                        return self::request($new_name , "" , false , $requestdata[$name]);
                    }
                }
            } else {
                $_REQUEST[$key] = $value;
            }
        }
    }

}

?>
