<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 24/12/2017
 * Time: 16:57
 */

namespace Edogawa\Core\Route;


use Edogawa\App\Controllers\Erreur;
use Edogawa\Core\Controllers\EdogawaController;
use Edogawa\Core\Requete\RequestData;
use Edogawa\Core\Requete\RequestDataInterface;
use Edogawa\Helpers\FlashMessage;
use Edogawa\Helpers\Str;

/**
 * Class Route
 * @package Edogawa\Core\Route
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Route
{
    /**
     * La variable qui contient l'itération courante des callbacks ou string
     *
     * @var int
     */
    private static $key = 0;

    /**
     * Contient l'ensemble des paramètres de la route, les callbacks et les string
     *
     * @var array
     */
    private static $function = [] ;

    /**
     * Contient le controller passé en paramètre
     *
     * @var string
     */
    private static $controller;

    /**
     * Contient l'ensemble des routes du projet
     *
     * @var array
     */
    private static $route = [];


    private static $req;

    /**
     * Contient le nombre de message d'information de type "warning"
     *
     * @var int
     */
    private static $warning = 0;

    /**
     * Valide les URL passées dans le fichier Route.php
     * Trouve les paramètres passées dans l'URL et retourne les paramètres
     *
     * @param string $url
     * @return array|bool
     */
    private static function validateURL(string $url)
    {
        $parameter = [];
        $params = explode('/',trim($url,'/'));
        $request_url = explode('/',trim(URL,'/'));
        if (count($request_url) == count($params)){
            foreach ($params as $key => $param) {
                if (preg_match_all('#(:[a-zA-Z0-9\-_\.]{1,})(\(.*\))?#',$param , $matches)){
                    for ($i=0 ; $i<count($matches[0]) ; $i++) {
                        if ($matches[2][$i] != ""){
                            $pattern = ltrim($matches[2][$i] , "(");
                            $pattern = rtrim($pattern , ")");
                            if (!preg_match("#^$pattern$#",$request_url[$key])){
                                /**
                                 * URL incompatible avec la regex
                                 */
                                return false;
                            }
                            else{
                                $parameter[trim($matches[1][$i] , ':')] = $request_url[$key];
                            }
                        }else{
                            $parameter[trim($matches[1][$i] , ':')] = $request_url[$key];
                        }
                    }
                }else{
                    $param = addcslashes($param,'/');
                    if (!URL_CASE_SENSITIVE){
                        $param = Str::toLower($param);
                        $parametre = Str::toLower($request_url[$key]);
                    }


                    if (!preg_match('#^'.$param.'$#',$parametre)){
                        return false;
                    }
                    /**
                     * Pas de paramètres dans l'URL
                     */
                }
            }
        }else{
            /**
             * Pas de correspondance pour l'URL d'appel
             */
            return false;
        }
        /**
         * Tout est OK
         */
        self::$controller = new EdogawaController();
        return $parameter;
    }

    /**
     * Fais appel au controller voulu ainsi que la méthode
     *
     * @param string $param
     * @param RequestDataInterface $request
     * @return mixed|string
     */
    private static function redirectToController(string $param , RequestDataInterface $request)
    {
        $data = "";
        $params = explode('$' , $param);
        $className = $params[0] ?? 'Site';
        $method = $params[1] ?? 'index';
        $className = "Edogawa\\App\\Controllers\\".$className;

        $urlParams = [];
        if(count($params) > 2){
            unset($params[0]);
            unset($params[1]);
            $urlParams = $params;
        }

        if (class_exists($className)){
            $controller = new $className($request);
            if (method_exists($className,$method)){
                $data = call_user_func_array(array($controller , $method), $urlParams);
            }else{
                $e = new Erreur();
                $data = $e->Erreur404();
            }
        }
        return $data;
    }

    /**
     * Parse par la méthode get l'URL contenu dans le path
     *
     * @param string $path
     * @param array ...$function
     */
    public static function get(string $path , ...$function) : void
    {
        self::$route[] = array(
            'method' => '_get',
            'path' => $path,
            'function' => $function
        );
    }

    /**
     * Parse par la méthode post l'URL contenu dans le path
     *
     * @param string $path
     * @param array ...$function
     */
    public static function post(string $path , ...$function) : void
    {
        self::$route[] = array(
            'method' => '_post',
            'path' => $path,
            'function' => $function
        );
    }

    /**
     * Donne accès au CRUD à partir de l'URL contenu dans le path
     * Le CRUD est sous la forme :
     *      {DESCRIPTION : URL ==> CONTROLLER$METHOD}
     *      Page affichée pour l'insertion et l'affichage : $path ==> $path$index
     *      Page affichée pour la mise à jour : $path/update/:id ==> $path$update
     *      Page pour le traitement par la méthode POST de l'insertion : $path/insert ==> $path$insert
     *      Page pour le traitement par la méthode POST de la mise à jour : $path/update ==> $path$update_data
     *      Page pour le traitement par la méthode POST de la suppression : $path/remove/:id ==> $path$remove
     * @param string $path
     * @param string $controller
     * @param string $id
     * @param string $param
     * @param callable|string $function
     */
    public static function CRUD(string $path , string $controller, string $id, string $param = "C-R-U-D", $function= "") : void
    {
      $ids = explode('|' , $id);
        $id = implode('/:' , $ids);
        $explode_param = explode('-',$param);
        foreach ($explode_param as $key => $item) {
            switch ($item){
                case 'C' : {
                    self::$route[] = array(
                        'method' => '_get',
                        'path' => $path,
                        'function' => (empty($function) ? [$controller] : [$function,$controller])
                    );
                    self::$route[] = array(
                        'method' => '_post',
                        'path' => $path,
                        'function' => (empty($function) ? [$controller.'$insert'] : [$function,$controller.'$insert'])
                    );
                    break;
                }
                case 'R' : {
                    self::$route[] = array(
                        'method' => '_get',
                        'path' => $path,
                        'function' => (empty($function) ? [$controller.'$show'] : [$function,$controller.'$show'])
                    );
                    break;
                }
                case 'U' : {
                    self::$route[] = array(
                        'method' => '_get',
                        'path' => $path.'/update/:'.$id,
                        'function' => (empty($function) ? [$controller.'$update'] : [$function,$controller.'$update'])
                    );
                    self::$route[] = array(
                        'method' => '_post',
                        'path' => $path.'/update',
                        'function' => (empty($function) ? [$controller.'$update_data'] : [$function,$controller.'$update_data'])
                    );
                    break;
                }
                case 'D' : {
                    self::$route[] = array(
                        'method' => '_get',
                        'path' => $path.'/remove/:'.$id,
                        'function' => (empty($function) ? [$controller.'$remove'] : [$function,$controller.'$remove'])
                    );
                    break;
                }
            }

            if (!in_array($item , ['C' , 'R' , 'U' , 'D'])){
                self::$warning++;
            }
        }

    }

    /**
     * Parse par la méthode put l'URL contenu dans le path
     *
     * @param string $path
     * @param array ...$function
     */
    public static function put(string $path , ...$function) : void
    {
        self::$route[] = array(
            'method' => '_put',
            'path' => $path,
            'function' => $function
        );
    }

    /**
     * Parse par la méthode delete l'URL contenu dans le path
     *
     * @param string $path
     * @param array ...$function
     */
    public static function delete(string $path , ...$function) : void
    {
        self::$route[] = array(
            'method' => '_delete',
            'path' => $path,
            'function' => $function
        );
    }

    /**
     * Parse par la méthode patch l'URL contenu dans le path
     *
     * @param string $path
     * @param array ...$function
     */
    public static function patch(string $path , ...$function) : void
    {
        self::$route[] = array(
            'method' => '_patch',
            'path' => $path,
            'function' => $function
        );
    }

    /**
     * Parse l'URL contenu dans le path quelques soit la méthode
     *
     * @param string $path
     * @param array ...$function
     */
    public static function all(string $path , ...$function) : void
    {
        self::$route[] = array(
            'method' => '_all',
            'path' => $path,
            'function' => $function
        );
    }

    /**
     * Fais appel à la méthode d'execution et de validation de la route pour la méthode GET
     *
     * @param string $path
     * @param array $function
     * @return bool|string
     */
    private static function _get(string $path , array $function)
    {
        return self::execRoute($path , $function , 'GET');
    }

    /**
     * Fais appel à la méthode d'execution et de validation de la route pour la méthode PUT
     *
     * @param string $path
     * @param array $function
     * @return bool|string
     */
    private static function _put(string $path , array $function)
    {
        return self::execRoute($path , $function , 'PUT');
    }

    /**
     * Fais appel à la méthode d'execution et de validation de la route pour la méthode POST
     *
     * @param string $path
     * @param array $function
     * @return bool|string
     */
    private static function _post(string $path , array $function)
    {
        return self::execRoute($path , $function , 'POST');
    }

    /**
     * Fais appel à la méthode d'execution et de validation de la route pour la méthode DELETE
     *
     * @param string $path
     * @param array $function
     * @return bool|string
     */
    private static function _delete(string $path , array $function)
    {
        return self::execRoute($path , $function , 'DELETE');
    }

    /**
     * Fais appel à la méthode d'execution et de validation de la route pour la méthode PATCH
     *
     * @param string $path
     * @param array $function
     * @return bool|string
     */
    private static function _patch(string $path , array $function)
    {
        return self::execRoute($path , $function , 'PATCH');
    }

    /**
     * Fais appel à la méthode d'execution et de validation de la route pour toutes les méthodes
     *
     * @param string $path
     * @param array $function
     * @return bool|string
     */
    private static function _all(string $path , array $function) : ?string
    {
        return self::execRoute($path , $function , 'ANY');
    }

    /**
     * Fais appel à la méthode de vérification de l'URL et exécute le code pour une route
     *
     * @param string $path
     * @param array $function
     * @param string $requete
     * @return bool|mixed|string
     */
    private static function execRoute(string $path , array $function , string $requete){
        self::$function = $function;

        $next = function(){
            self::next();
        };

        $validateURLResponse = self::validateURL($path);

        if ($validateURLResponse !== false and ($_SERVER['REQUEST_METHOD'] == $requete or $requete == 'ANY')){
            $request = new RequestData();
            $request->setRequestMethod($_SERVER['REQUEST_METHOD']);
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $request->setRequest($_POST);
            }elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
                $request->setRequest($_GET);
            }else{
                $request->setRequest($_REQUEST);
            }
            $request->setParams($validateURLResponse);
            $request->setPath($path);

            self::$req = $request;
            if (is_string($function[self::$key])){
                return self::redirectToController($function[self::$key] , $request);
            }else{
                return $function[self::$key]($request, self::$controller , $next);
            }
        }else{
            return -1;
        }
    }

    /**
     * Pointe vers la fonction suivante dans le cas d'existence d'un middleware
     */
    private static function next() : void
    {
        self::$key++;
        $next = function(){
            self::next();
        };
        if (self::$key < count(self::$function)){
            if (is_string(self::$function[self::$key])){
                echo self::redirectToController(self::$function[self::$key] , self::$req);
            }else{
                self::$function[self::$key](self::$req, self::$controller , $next);
            }
        }

    }

    /**
     * Exécute les routes définies
     */
    public static function run() : void
    {
        require_once "app/Route.php";
        if (self::$warning > 0){
            FlashMessage::get();
            FlashMessage::set('warning' , 'Paramètre incompatible pour un CRUD');
        }

        $found = false;
        foreach (self::$route as $route) {
            $return = self::{$route['method']}($route['path'] , $route['function']);
            if ($return != -1){
                $found = true;
                if (is_array($return) or is_object($return)){
                    foreach ($return as $item) {
                        echo $item;
                    }
                }else{
                    echo $return;
                }
                break;
            }
        }

        if (! $found){
            $e = new Erreur();
            echo $e->Erreur404();
        }
    }

}
