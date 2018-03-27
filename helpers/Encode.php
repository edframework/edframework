<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 15/12/2017
 * Time: 23:54
 */

namespace Edogawa\Helpers;

/**
 * Class Encode
 * @package Edogawa\Helpers
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Encode
{

    /**
     * Converti en json un tableau
     *
     * @param array|string $str
     * @return json
     */
    public static function json($str)
    {
        return json_encode($str);
    }

    /**
     * Decode un json
     *
     * @param json $str
     * @return string
     */
    public static function json_d($str)
    {
        return json_decode($str);
    }

    /**
     * Encode une URL
     * @param string $str
     * @return string
     */
    public static function url(string $str)
    {
        return urlencode($str);
    }

    /**
     * Décode une URL
     *
     * @param string $str
     * @return string
     */
    public static function url_d(string $str)
    {
        return urldecode($str);
    }

    /**
     * Encode en base64
     *
     * @param string $str
     * @return string
     */
    public static function base64(string $str)
    {
        return base64_encode($str);
    }

    /**
     * Décode en base64
     *
     * @param string $str
     * @return bool|string
     */
    public static function base64_d(string $str)
    {
        return base64_decode($str);
    }

    /**
     * Encode en utf8
     *
     * @param string $str
     * @return string
     */
    public static function utf8(string $str)
    {
        return utf8_encode($str);
    }

    /**
     * Décode en utf8
     *
     * @param string $str
     * @return string
     */
    public static function utf8_d(string $str)
    {
        return utf8_decode($str);
    }

}