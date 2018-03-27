<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 02/01/2018
 * Time: 11:59
 */

namespace Edogawa\Core\Requete;


/**
 * Class RequestData
 * @package Edogawa\Core\Requete
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class RequestData implements RequestDataInterface
{

    /**
     * Contient les données envoyées par les requêtes POST GET PUT DELETE PATCH
     *
     * @var array
     */
    protected $request = [];

    /**
     * Contient les données envoyées par l'URL
     *
     * @var array
     */
    protected $params = [];

    /**
     * Contient le path de la page
     *
     * @var string
     */
    protected $path = "";

    /**
     * Méthode HTTP de la requête
     *
     * @var string
     */
    protected $requestMethod = "";


    /**
     * Retourne toutes les données d'une requête
     *
     * @return array
     */
    public function getRequests() : array
    {
        return $this->request;
    }

    /**
     * Retourne la donnée passée en paramètre
     *
     * @param string $key
     * @return mixed
     */
    public function request(string $key) : mixed
    {
        return $this->request[$key];
    }

    /**
     * Définit les données de la requête
     *
     * @param array $request
     */
    public function setRequest(array $request) : void
    {
        $this->request = $request;
    }

    /**
     * Définit les paramètres de l'URL
     *
     * @return array
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * Retourne la donnée passée en  paramètre
     *
     * @param string $key
     * @return mixed
     */
    public function param(string $key) : mixed
    {
        return $this->params[$key];
    }

    /**
     * Retourne toutes les données passées en paramètre
     *
     * @param array $params
     */
    public function setParams(array $params) : void
    {
        $this->params = $params;
    }

    /**
     * Redirige vers le path
     *
     * @param string $path
     */
    public function redirectTo(string $path) : void
    {
        header('Location:'.WROOT.$path);
    }

    /**
     * Recupère le path de la requête GET
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Définit le path courant
     *
     * @param string $path
     */
    public function setPath(string $path) : void
    {
        $this->path = $path;
    }

    /**
     * Définit la méthode d'appel à la page
     *
     * @param string $requestMethod
     * @return RequestData
     */
    public function setRequestMethod(string $requestMethod): RequestData
    {
        $this->requestMethod = $requestMethod;
        return $this;
    }

    /**
     * Recupère la méthode d'accès
     *
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

}
