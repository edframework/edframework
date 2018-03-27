<?php
namespace Edogawa\Core\Html;
use Edogawa\Core\Security\Debug;

/**
 * Class Vue
 *
 * @package Edogawa\Core\Html
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Vue implements VueInterface
{

    /**
     * Active le debug
     */
    public function setDebug() : void
    {
        Debug::setDebug();
    }

    /**
     * Inclut un fichier CSS
     *
     * @param string $nomFichier
     * @return string
     */
    public function css(string $nomFichier) : string
    {
        return "<link type='text/css' rel='stylesheet' href='" . RES . "css/{$nomFichier}.css'/>";
    }

    /**
     * Inclut un fichier JS
     *
     * @param string $nomFichier
     * @return string
     */
    public function js(string $nomFichier) : string
    {
        return "<script type='text/javascript' src='" . RES . "js/{$nomFichier}.js'></script>";
    }

    /**
     * Retourne une URL
     *
     * @param string $url
     * @return string
     */
    public function url(string $url) : string
    {
        return WROOT . "{$url}";
    }

    /**
     * Redirige vers une URL
     *
     * @param string $url
     */
    public function redirectTo(string $url) : void
    {
        header('Location:' . WROOT . "{$url}");
    }

    /**
     * Affiche du texte
     *
     * @param string $texte
     */
    public function afficher(string $texte) : void
    {
        if (is_array($texte)) {
            foreach ($texte as $key => $value) {
                $this->afficher($value);
            }
        } else {
            echo $texte . "\n";
        }
    }
}

?>
