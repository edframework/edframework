<?php
namespace Edogawa\Core\App;

/**
 * Classe Language
 *
 * Fournit des méthodes statiques pour gérer la langue passée par l'URL
 *
 * @package Edogawa\Core\App
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Language
{
    /**
     * Le contenu Json du fichier passé en paramètre de la méthode setLang
     *
     * @var string
     */
    private static $json;

    /**
     * Hydrate la variable $json avec le contenu du fichier dans le paramètre
     *
     * @param $params
     * @return mixed
     */
    public static function setLang(&$params)
    {
        $lang = ['fr' , 'en'];
        switch (strtolower($params[0])) {
            case 'fr':
                $filename = "public/lang/fr.json";
                break;
            case 'en' :
                $filename = "public/lang/en.json";
                break;
            default :
                $filename = "public/lang/fr.json";
        }
        self::$json = App::getJsonLoader($filename);
        if (in_array(strtolower($params[0]) , $lang)) {
            return array_shift($params)."/";
        }
        return "";
    }

    /**
     * Retourne le contenu de la variable $json
     *
     * @return Json
     */
    public static function getJson()
    {
        return self::$json;
    }
}

