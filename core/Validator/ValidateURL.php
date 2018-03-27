<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 15/12/2017
 * Time: 22:28
 */

namespace Edogawa\Core\Validator;


use Edogawa\App\Controllers\Erreur;
use Edogawa\Core\Requete\Requete;
use Edogawa\Helpers\Str;

/**
 * Class ValidateURL
 * @package Edogawa\Core\Validator
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class ValidateURL
{

    /**
     * Vérifie si l'URL est une ressource pour rediriger vers le dossier de ressources public ou si c'est une instruction
     *
     * @param string $param
     * @return int
     */
    public static function validate(string $param)
    {
        $res = 0;
        if (preg_match('#^.*\.(map|css|js|pl|txt|otf|ttf|eot|woff|woff2|svg|jpg|jpeg|gif|png|JPG|JPEG|GIF|PNG).{0,10}$#', $param)) {
            header("Location:" . WROOT . "public/$param");
        }
        return $res;
    }
}