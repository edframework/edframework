<?php
namespace Edogawa\Core\Html;
use Edogawa\Core\Security\Debug;
use Edogawa\Helpers\ArrayString;

/**
 * Class Form
 *
 * @package Edogawa\Core\Html
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Form implements FormInterface
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
    public function encadrer(string $balise, string $texte, array  $attribut)
    {
        $attr = "";
        foreach ($attribut as $key => $value) {
            $attr .= " {$key}='{$value}'";
        }
        $texte = ArrayString::ArrayToString('', $texte);
        return (Debug::getDebug() ? $this->retour : "") . "<{$balise}{$attr}>{$texte}</{$balise}>" . (Debug::getDebug() ? $this->retour : "");
    }

    /**
     * Génère un formulaire
     *
     * @param string $texte
     * @param string $method
     * @param string $action
     * @param bool $formData
     * @param array $attribut
     * @return string
     */
    public function form(string $texte = "", string $method = "post", string $action = "", bool $formData = false, array $attribut = [])
    {
        $attribut['method'] = $method;
        (!empty($action) ? $attribut['action'] = $action : '');
        (($formData == true) ? $attribut['enctype'] = "multipart/form-data" : '');
        return $this->encadrer('form', $texte, $attribut);
    }

    /**
     * Génère une balise input
     *
     * @param string $type
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function input(string $type, string $id = "", string $name = "", array $attribut = [])
    {
        $attr = "";
        foreach ($attribut as $key => $value) {
            $attr .= " {$key}=\"{$value}\"";
        }
        return "<input type=\"{$type}\" id=\"{$id}\" name=\"{$name}\"{$attr}/>";
    }

    /**
     * Génère une balise input avec le type text
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function textInput(string $id = "", string $name = "", array $attribut = [])
    {
        return $this->input('text', $id, $name, $attribut);
    }

    /**
     * Génère une balise input avec le type password
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function passwordInput(string $id = "", string $name = "", array $attribut = [])
    {
        return $this->input('password', $id, $name, $attribut);
    }

    /**
     * Génère une balise input avec le type date
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function dateInput(string $id = "", string $name = "", array $attribut = [])
    {
        return $this->input('date', $id, $name, $attribut);
    }

    /**
     * Génère une balise input avec le type time
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function heureInput(string $id = "", string $name = "", array $attribut = [])
    {
        return $this->input('time', $id, $name, $attribut);
    }

    /**
     * Génère une balise input avec le type number
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function numberInput(string $id = "", string $name = "", array $attribut = [])
    {
        return $this->input('number', $id, $name, $attribut);
    }

    /**
     * Génère une balise input avec le type hidden
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function hiddenInput(string $id = "", string $name = "", array $attribut = [])
    {
        return $this->input('hidden', $id, $name, $attribut);
    }

    /**
     * Génère une balise input avec le type radio
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function radioInput(string $id = "", string $name = "", array $attribut = [])
    {
        return $this->input('radio', $id, $name, $attribut);
    }

    /**
     * Génère une balise input avec le type file
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function fileInput(string $id = "", string $name = "", array $attribut = [])
    {
        return $this->input('file', $id, $name, $attribut);
    }

    /**
     * Génère une balise input avec le type checkbox
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return string
     */
    public function checkboxInput(string $id = "", string $name = "", array $attribut = [])
    {
        return $this->input('checkbox', $id, $name, $attribut);
    }

    /**
     * Génère une balise select
     *
     * @param array $option
     * @param array $attribut
     * @return string
     */
    public function select(array $option, array $attribut = [])
    {
        $texte = "";
        foreach ($option as $key => $value) {
            $texte .= $this->encadrer($value[0], $value[1], (!empty($value[2]) ? $value[2] : []));
        }

        return $this->encadrer('select', $texte, $attribut);
    }

    /**
     * Génère une balise label
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
     * Génère une balise button
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
     * Génère une balise textarea
     *
     * @param string $texte
     * @param array $attribut
     * @return string
     */
    public function textarea(string $texte, array $attribut = [])
    {
        return $this->encadrer('textarea', $texte, $attribut);
    }


}

?>
