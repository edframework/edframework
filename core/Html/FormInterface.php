<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 02/01/2018
 * Time: 14:15
 */

namespace Edogawa\Core\Html;


/**
 * Interface FormInterface
 *
 * @package Edogawa\Core\Html
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
interface FormInterface
{
    /**
     * Encadre le texte donné par la balise sélectionnée
     *
     * @param string $balise
     * @param string $texte
     * @param array $attribut
     * @return mixed
     */
    public function encadrer(string $balise, string $texte, array  $attribut);

    /**
     * Génère un formulaire
     *
     * @param string $texte
     * @param string $method
     * @param string $action
     * @param bool $formData
     * @param array $attribut
     * @return mixed
     */
    public function form(string $texte, string $method , string $action , bool $formData, array  $attribut);

    /**
     * Génère une balise input
     *
     * @param string $type
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function input(string $type, string $id, string $name , array  $attribut);

    /**
     * Génère une balise input avec le type text
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function textInput(string $id, string $name , array  $attribut);

    /**
     * Génère une balise input avec le type password
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function passwordInput(string $id , string $name , array  $attribut);

    /**
     * Génère une balise input avec le type date
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function dateInput(string $id , string $name , array  $attribut);

    /**
     * Génère une balise input avec le type time
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function heureInput(string $id , string $name , array  $attribut);

    /**
     * Génère une balise input avec le type number
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function numberInput(string $id , string $name , array  $attribut);

    /**
     * Génère une balise input avec le type hidden
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function hiddenInput(string $id , string $name , array  $attribut);

    /**
     * Génère une balise input avec le type radio
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function radioInput(string $id , string $name , array  $attribut);

    /**
     * Génère une balise input avec le type file
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function fileInput(string $id , string $name , array  $attribut);

    /**
     * Génère une balise input avec le type checkbox
     *
     * @param string $id
     * @param string $name
     * @param array $attribut
     * @return mixed
     */
    public function checkboxInput(string $id , string $name , array  $attribut);

    /**
     * Génère une balise select
     *
     * @param array $option
     * @param array $attribut
     * @return mixed
     */
    public function select(array $option, array  $attribut);

    /**
     * Génère une balise label
     *
     * @param string $texte
     * @param array $attribut
     * @return mixed
     */
    public function label(string $texte, array  $attribut);

    /**
     * Génère une balise button
     *
     * @param string $texte
     * @param array $attribut
     * @return mixed
     */
    public function button(string $texte, array  $attribut);

    /**
     * Génère une balise textarea
     *
     * @param string $texte
     * @param array $attribut
     * @return mixed
     */
    public function textarea(string $texte, array  $attribut);

}