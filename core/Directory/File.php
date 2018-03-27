<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 13/12/2017
 * Time: 20:56
 */

namespace Edogawa\Core\Directory;

/**
 * Classe File
 *
 * Fournit des méthodes statiques pour créer, ouvrir et gérer les fichiers
 *
 * @package Edogawa\Core\Directory
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class File
{
    /**
     * Créer un fichier
     *
     * @param string $path
     * @return bool|resource
     */
    public static function create(string $path)
    {
        return @fopen($path, 'w');
    }

    /**
     * Ourvir un fichier
     *
     * @param string $path
     * @return bool|resource
     */
    public static function openAppend(string $path)
    {
        return @fopen($path, 'a');
    }

    /**
     * Lire un fichier
     *
     * @param string $path
     * @return bool|string
     */
    public static function read(string $path)
    {
        return file_get_contents($path);
    }

    /**
     * Ecrit dans un fichier
     *
     * @param resource $f
     * @param string $data
     * @return bool|int
     */
    public static function write($f, string $data)
    {
        return fwrite($f, $data);
    }

    /**
     * Ajouter du contenu à un fichier
     *
     * @param resource $f
     * @param string $data
     * @return bool|int
     */
    public static function append($f, string $data)
    {
        return fputs($f, $data);
    }

    /**
     * Ouvrir un fichier en lecture
     *
     * @param string $path
     * @return bool|resource
     */
    public static function open(string $path)
    {
        return fopen($path, 'r');
    }

    /**
     * Vérifie si un fichier existe
     *
     * @param string $path
     * @return bool
     */
    public static function exists(string $path)
    {
        return file_exists($path);
    }

    /**
     * Ferme un fichier
     *
     * @param resource $f
     * @return bool
     */
    public static function close($f){
        return @fclose($f);
    }

    /**
     * Récupérer le contenu d'un fichier
     *
     * @param string $path
     * @return bool|string
     */
    public static function get_contents(string $path)
    {
        return file_get_contents($path);
    }
}