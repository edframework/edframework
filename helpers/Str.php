<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 15/12/2017
 * Time: 22:04
 */

namespace Edogawa\Helpers;

/**
 * Class Str
 * @package Edogawa\Helpers
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Str
{
    /**
     * Converti en minuscule
     *
     * @param string $str
     * @return string
     */
    public static function toLower(string $str)
    {
        return strtolower($str);
    }

    /**
     * Converti en majuscule
     *
     * @param string $str
     * @return string
     */
    public static function toUpper(string $str)
    {
        return strtoupper($str);
    }

    /**
     * Converti le premier caractère en majuscule les autres en minuscule
     *
     * @param string $str
     * @return string
     */
    public static function ucFirst(string $str)
    {
        return ucfirst(strtolower($str));
    }

    /**
     * Mélange les lettres dans une chaine de caractère
     *
     * @param string $str
     * @return string
     */
    public static function shuffle(string $str)
    {
        return str_shuffle($str);
    }

    /**
     * Coupe une chaine de caractères à un delimiter
     *
     * @param string $str
     * @param string $delimiter
     * @return array
     */
    public static function split(string $str, string $delimiter)
    {
        return explode($delimiter, $str);
    }
}