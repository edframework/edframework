<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 02/01/2018
 * Time: 11:59
 */

namespace Edogawa\Core\Requete;


/**
 * Interface RequestDataInterface
 * @package Edogawa\Core\Requete
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
interface RequestDataInterface
{

    /**
     * Retourne toutes les données d'une requête
     *
     * @return array
     */
    public function getRequests() : array ;

    /**
     * Retourne la donnée passée en paramètre
     *
     * @param string $key
     * @return mixed
     */
    public function request(string $key) : mixed;

    /**
     * Définit les paramètres de l'URL
     *
     * @return array
     */
    public function getParams() : array ;

    /**
     * Retourne la donnée passée en  paramètre
     *
     * @param string $key
     * @return mixed
     */
    public function param(string $key) : mixed;

    /**
     * Définit les données de la requête
     *
     * @param array $request
     */
    public function setRequest(array $request) : void;

    /**
     * Retourne toutes les données passées en paramètre
     *
     * @param array $params
     */
    public function setParams(array $params) : void;

    /**
     * Redirige vers le path
     *
     * @param string $path
     */
    public function redirectTo(string $path) : void;

    /**
     * Définit le path courant
     *
     * @param string $path
     */
    public function setPath(string $path) : void;

    /**
     * Recupère le path de la requête GET
     *
     * @return string
     */
    public function getPath() : string;

}