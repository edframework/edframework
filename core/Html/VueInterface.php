<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 02/01/2018
 * Time: 14:38
 */

namespace Edogawa\Core\Html;


/**
 * Interface VueInterface
 * @package Edogawa\Core\Html
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
interface VueInterface
{
    /**
     * Active le debug
     */
    public function setDebug() : void;

    /**
     * Inclut un fichier CSS
     *
     * @param string $nomFichier
     * @return string
     */
    public function css(string $nomFichier) : string ;

    /**
     * Inclut un fichier JS
     *
     * @param string $nomFichier
     * @return string
     */
    public function js(string $nomFichier) : string ;

    /**
     * Retourne une URL
     *
     * @param string $url
     * @return string
     */
    public function url(string $url) : string ;

    /**
     * Redirige vers une URL
     *
     * @param string $url
     */
    public function redirectTo(string $url) : void;

    /**
     * Affiche du texte
     *
     * @param string $texte
     */
    public function afficher(string $texte) : void;

}