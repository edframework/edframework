<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 02/01/2018
 * Time: 14:44
 */

namespace Edogawa\Core\Html;


/**
 * Interface HtmlInterface
 *
 * @package Edogawa\Core\Html
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
interface HtmlInterface
{
    /**
     * Encadre le texte donné par la balise sélectionnée
     *
     * @param string $balise
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function encadrer(string $balise, string $texte, array $attribut);

    /**
     * Génère la balise h1
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h1(string $texte, array $attribut = []);

    /**
     * Génère la balise h2
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h2(string $texte, array $attribut = []);

    /**
     * Génère la balise h3
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h3(string $texte, array $attribut = []);

    /**
     * Génère la balise h4
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h4(string $texte, array $attribut = []);

    /**
     * Génère la balise h5
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h5(string $texte, array $attribut = []);

    /**
     * Génère la balise h6
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h6(string $texte, array $attribut = []);

    /**
     * Génère la balise div
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function div(string $texte, array $attribut = []);

    /**
     * Génère le paragraphe p
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function p(string $texte, array $attribut = []);

    /**
     * Génère la balise span
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function span(string $texte, array $attribut = []);

    /**
     * Génère la balise head
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function head(string $texte, array $attribut = []);

    /**
     * Génère la balise header
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function header(string $texte, array $attribut = []);

    /**
     * Génère la balise body
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function body(string $texte, array $attribut = []);

    /**
     * Génère la balise title
     *
     * @param string $texte
     * @return string
     */
    public function title(string $texte);

    /**
     * Génère la balise footer
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function footer(string $texte, array $attribut = []);

    /**
     * Génère la balise section
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function section(string $texte, array $attribut = []);

    /**
     * Génère la balise article
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function article(string $texte, array $attribut = []);

    /**
     * Génère la balise i
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function i(string $texte, array $attribut = []);

    /**
     * Génère la balise script
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function script(string $texte, array $attribut = []);

    /**
     * Génère la balise fieldset
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function fieldset(string $texte, array $attribut = []);

    /**
     * Génère la balise legend
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function legend(string $texte, array $attribut = []);

    /**
     * Génère la balise label
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function label(string $texte, array $attribut = []);

    /**
     * Génère la balise html
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function html(string $texte, array $attribut = []);

    /**
     * Génère un anchor
     *
     * @param string $texte
     * @param string $href
     * @param array $attribut
     * @return string
     */
    public function a(string $texte, string $href, array $attribut = []);

    /**
     * Génère la balise img
     *
     * @param string $src
     * @param string $title
     * @param array $attribut
     * @return string
     */
    public function img(string $src, string $title, array $attribut = []);

    /**
     * Génère un doctype
     *
     * @return string
     */
    public function doctype();

    /**
     * Génère un bouton
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function button(string $texte, array $attribut = []);

    /**
     * Génère un meta
     *
     * @param string $charset
     * @param string $name
     * @param string $content
     * @param array $attribut
     * @return string
     */
    public function meta(string $charset, string $name = "", string $content = "", array $attribut = []);

    /**
     * Génère une liste
     *
     * @param string $type
     * @param $li
     * @param array $attribut
     * @return string
     */
    public function list(string $type, $li, array $attribut = []);

    /**
     * Génère une liste ul
     *
     * @param $li
     * @param array $attribut
     * @return string
     */
    public function ul($li, array $attribut = []);

    /**
     * Génère une balise ol
     *
     * @param $li
     * @param array $attribut
     * @return string
     */
    public function ol($li, array $attribut = []);

    /**
     * Génère une balise nav
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function nav(string $texte, array $attribut = []);

    /**
     * Génère un ou plusieurs retour à la ligne
     *
     * @param int $nombre
     * @return string
     */
    public function br(int $nombre = 1);

    /**
     * Génère un ou plusieurs séparateurs
     *
     * @param int $nombre
     * @return string
     */
    public function hr(int $nombre = 1);

    /**
     * Génère un ou plusieurs espaces
     *
     * @param int $nombre
     * @return string
     */
    public function nbs(int $nombre = 1);
}