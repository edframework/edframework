<?php

namespace Edogawa\Core\App;

/**
 * Classe Loader
 *
 * Fournit des méthodes statiques pour charger différents types de fichiers
 *
 * @package Edogawa\Core\App
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Loader
{
    /**
     * Retourne le contenu du fichier en paramètre
     *
     * @param string $filename
     * @return string
     */
    public static function json($filename)
    {
        $f = file_get_contents($filename);
        return json_decode($f);
    }

    /**
     * Retourne le contenu du fichier en paramètre
     *
     * @param string $filename
     * @return bool|string
     * @throws \Exception
     */
    public static function php($filename)
    {
        if (is_file('app/Vues/pages/'.$filename)){
            $contenu = file_get_contents("app/Vues/pages/" . $filename);
            return $contenu;
        }else{
            throw new \Exception('File not found');
        }
    }
}

