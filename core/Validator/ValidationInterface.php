<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 02/01/2018
 * Time: 15:05
 */

namespace Edogawa\Core\Validator;

/**
 * Interface ValidationInterface
 * @package Edogawa\Core\Validator
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
interface ValidationInterface
{
    /**
     * Valide une adresse mail
     *
     * @param string $email
     * @return bool
     */
    public function validateEmail(string $email) : bool;

    /**
     * Valide un nombre
     *
     * @param string $number
     * @return bool
     */
    public function validateNumber(string $number) : bool;

    /**
     * Validate un numéro de telephone
     *
     * @param string $tel
     * @return bool
     */
    public function validateTel(string $tel) : bool;

    /**
     * Valide une URL de site web
     *
     * @param string $site
     * @return bool
     */
    public function validateSiteWeb(string $site) : bool;

    /**
     * Valide un mot de passe
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password) : bool;

    /**
     * Vérifie la contenance en nombre d'un string
     *
     * @param string $text
     * @return bool
     */
    public function verifyIfContainsNumber(string $text) : bool;

    /**
     * Vérifie la contenance en lettres d'un string
     *
     * @param string $text
     * @return bool
     */
    public function verifyIfContainsLetter(string $text) : bool;

    /**
     * Vérifie la contenance en caractères spéciaux d'un string
     *
     * @param string $text
     * @return bool
     */
    public function verifyIfContainsSpecialChars(string $text) : bool;

    /**
     * Valide avec les paramètres données
     *
     * @param array $fields
     * @return bool
     */
    public function validate(array $fields) : bool;

    /**
     * Vérifie si la méthode validate est validé
     *
     * @return bool
     */
    public function isValidate(): bool;
}