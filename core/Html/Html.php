<?php
namespace Edogawa\Core\Html;

use Edogawa\Helpers\ArrayString;
use Edogawa\Core\Security\Debug;

/**
 * Class Html
 *
 * @package Edogawa\Core\Html
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Html implements HtmlInterface
{

    /**
     * Retour à la ligne
     *
     * @var string
     */
    private $retour = "\n";

    /**
     * Encadre le texte donné par la balise sélectionnée
     *
     * @param string $balise
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function encadrer(string $balise, string $texte, array $attribut)
    {
        $attr = "";
        foreach ($attribut as $key => $value) {
            $attr .= " {$key}='{$value}'";
        }
        $texte = ArrayString::ArrayToString('', $texte);
        return (Debug::getDebug() ? $this->retour : "") . "<{$balise}{$attr}>{$texte}</{$balise}>" . (Debug::getDebug() ? $this->retour : "");
    }

    /**
     * Génère une balise titre
     *
     * @param int $num
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    private function h(int $num, string $texte, array $attribut)
    {
        return $this->encadrer('h' . $num, $texte, $attribut);
    }

    /**
     * Génère la balise h1
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h1(string $texte, array $attribut = [])
    {
        return $this->h(1, $texte, $attribut);
    }

    /**
     * Génère la balise h2
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h2(string $texte, array $attribut = [])
    {
        return $this->h(2, $texte, $attribut);
    }

    /**
     * Génère la balise h3
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h3(string $texte, array $attribut = [])
    {
        return $this->h(3, $texte, $attribut);
    }

    /**
     * Génère la balise h4
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h4(string $texte, array $attribut = [])
    {
        return $this->h(4, $texte, $attribut);
    }

    /**
     * Génère la balise h5
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h5(string $texte, array $attribut = [])
    {
        return $this->h(5, $texte, $attribut);
    }

    /**
     * Génère la balise h6
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function h6(string $texte, array $attribut = [])
    {
        return $this->h(6, $texte, $attribut);
    }

    /**
     * Génère la balise div
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function div(string $texte, array $attribut = [])
    {
        return $this->encadrer('div', $texte, $attribut);
    }

    /**
     * Génère le paragraphe p
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function p(string $texte, array $attribut = [])
    {
        return $this->encadrer('p', $texte, $attribut);
    }

    /**
     * Génère la balise span
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function span(string $texte, array $attribut = [])
    {
        return $this->encadrer('span', $texte, $attribut);
    }

    /**
     * Génère la balise head
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function head(string $texte, array $attribut = [])
    {
        return $this->encadrer('head', $texte, $attribut);
    }

    /**
     * Génère la balise header
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function header(string $texte, array $attribut = [])
    {
        return $this->encadrer('header', $texte, $attribut);
    }

    /**
     * Génère la balise body
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function body(string $texte, array $attribut = [])
    {
        return $this->encadrer('body', $texte, $attribut);
    }

    /**
     * Génère la balise title
     *
     * @param string $texte
     * @return string
     */
    public function title(string $texte)
    {
        return $this->encadrer('title', $texte, []);
    }

    /**
     * Génère la balise footer
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function footer(string $texte, array $attribut = [])
    {
        return $this->encadrer('footer', $texte, $attribut);
    }

    /**
     * Génère la balise section
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function section(string $texte, array $attribut = [])
    {
        return $this->encadrer('section', $texte, $attribut);
    }

    /**
     * Génère la balise article
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function article(string $texte, array $attribut = [])
    {
        return $this->encadrer('article', $texte, $attribut);
    }

    /**
     * Génère la balise i
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function i(string $texte, array $attribut = [])
    {
        return $this->encadrer('i', $texte, $attribut);
    }

    /**
     * Génère la balise script
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function script(string $texte, array $attribut = [])
    {
        return $this->encadrer('script', $texte, $attribut);
    }

    /**
     * Génère la balise fieldset
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function fieldset(string $texte, array $attribut = [])
    {
        return $this->encadrer('fieldset', $texte, $attribut);
    }

    /**
     * Génère la balise legend
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function legend(string $texte, array $attribut = [])
    {
        return $this->encadrer('legend', $texte, $attribut);
    }

    /**
     * Génère la balise label
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function label(string $texte, array $attribut = [])
    {
        return $this->encadrer('label', $texte, $attribut);
    }

    /**
     * Génère la balise html
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function html(string $texte, array $attribut = [])
    {
        return $this->encadrer('html', $texte, $attribut);
    }

    /**
     * Génère un anchor
     *
     * @param string $texte
     * @param string $href
     * @param array $attribut
     * @return string
     */
    public function a(string $texte, string $href, array $attribut = [])
    {
        $attribut['href'] = $href;
        return $this->encadrer('a', $texte, $attribut);
    }

    /**
     * Génère la balise img
     *
     * @param string $src
     * @param string $title
     * @param array $attribut
     * @return string
     */
    public function img(string $src, string $title, array $attribut = [])
    {
        $attr = "";
        foreach ($attribut as $key => $value) {
            $attr .= " {$key}='{$value}'";
        }
        return "<img src='{$src}' title='{$title}'{$attr}/>" . (Debug::getDebug() ? $this->retour : "");
    }

    /**
     * Génère un doctype
     *
     * @return string
     */
    public function doctype()
    {
        return "<!DOCTYPE html>" . (Debug::getDebug() ? $this->retour : "");
    }

    /**
     * Génère un bouton
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function button(string $texte, array $attribut = [])
    {
        return $this->encadrer('button', $texte, $attribut);
    }

    /**
     * Génère un meta
     *
     * @param string $charset
     * @param string $name
     * @param string $content
     * @param array $attribut
     * @return string
     */
    public function meta(string $charset, string $name = "", string $content = "", array $attribut = [])
    {
        $attr = "";
        foreach ($attribut as $key => $value) {
            $attr .= " {$key}='{$value}'";
        }
        return "<meta " . (!empty($charset) ? "charset='{$charset}' " : "") . (!empty($name) ? "name='{$name}' " : "") . (!empty($content) ? "content='{$content}' " : "") . "{$attr}/>" . (Debug::getDebug() ? $this->retour : "");
    }

    /**
     * Génère une liste
     *
     * @param string $type
     * @param $li
     * @param array $attribut
     * @return string
     */
    public function list(string $type, $li, array $attribut = [])
    {
        $texte = "";

        foreach ($li as $key => $value) {
            $texte .= $this->encadrer('li', $value[0], (!empty($value[1]) ? $value[1] : []));
        }

        return $this->encadrer($type, $texte, $attribut);
    }

    /**
     * Génère une liste ul
     *
     * @param $li
     * @param array $attribut
     * @return string
     */
    public function ul($li, array $attribut = [])
    {
        return $this->list('ul', $li, $attribut);
    }

    /**
     * Génère une balise ol
     *
     * @param $li
     * @param array $attribut
     * @return string
     */
    public function ol($li, array $attribut = [])
    {
        return $this->list('ol', $li, $attribut);
    }

    /**
     * Génère une balise nav
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function nav(string $texte, array $attribut = [])
    {
        return $this->encadrer('nav', $texte, $attribut);
    }

    /**
     * Génère un ou plusieurs retour à la ligne
     *
     * @param int $nombre
     * @return string
     */
    public function br(int $nombre = 1)
    {
        return str_repeat('<br />', $nombre);
    }

    /**
     * Génère un ou plusieurs séparateurs
     *
     * @param int $nombre
     * @return string
     */
    public function hr(int $nombre = 1)
    {
        return str_repeat('<br />', $nombre);
    }

    /**
     * Génère un ou plusieurs espaces
     *
     * @param int $nombre
     * @return string
     */
    public function nbs(int $nombre = 1)
    {
        return str_repeat('&nbsp;', $nombre);
    }

}

?>
